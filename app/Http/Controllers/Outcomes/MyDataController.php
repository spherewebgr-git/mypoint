<?php

namespace App\Http\Controllers\Outcomes;

use App\Http\Controllers\Controller;
use App\Models\Outcomes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MyDataController extends Controller
{
    public function requestDocs() {
        $last = Outcomes::max('mark');

        $expenses = myDataRequestDocs($last);

        if($expenses) {
            foreach ($expenses->invoicesDoc->invoice as $expense) {
                $find = DB::table('outcomes')->where('shop', '=', $expense->issuer->vatNumber)->where('seira', '=', $expense->invoiceHeader->series)->where('outcome_number', '=', $expense->invoiceHeader->aa)->first();

                if($find == null) {
                    if($expense->invoiceHeader->invoiceType == '5.1' || $expense->invoiceHeader->invoiceType == '5.2') {
                        $price = -$expense->invoiceDetails->netValue;
                        $vat = -$expense->invoiceDetails->vatAmount;
                    } else {
                        $price = $expense->invoiceDetails->netValue;
                        $vat = $expense->invoiceDetails->vatAmount;
                    }
                    DB::table('outcomes')->insert(
                        array(
                            'hashID' => Str::substr(Str::slug(Hash::make($expense->issuer->vatNumber . $expense->mark)), 0, 32),
                            'seira' => $expense->invoiceHeader->series,
                            'outcome_number' => (int)$expense->invoiceHeader->aa,
                            'shop' => $expense->issuer->vatNumber,
                            'date' => $expense->invoiceHeader->issueDate,
                            'price' => $price,
                            'vat' => $vat,
                            'invType' => $expense->invoiceHeader->invoiceType,
                            'mark' => $expense->mark,
                            'file' => ''
                        )
                    );

                } else {
                    $find->mark = $expense->mark;
                    $find->save();
                }
//            if(DB::table('outcomes')->where('minMark', '=', 'NULL')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)) {
//                DB::table('outcomes')->update([
//                    'invType' => $expense->invType,
//                    'minMark' => $expense->minMark,
//                    'maxMark' => $expense->maxMark
//                ]);
//            }
            }
        }
        Session::flash('message', '???? ?????????????????????? ???????????????????????? ???? ????????????????');

        return redirect('/outcomes');
    }

    public function sendClassifications(Request $request, $hashID) {

        $outcome = Outcomes::query()->where('hashID', '=', $hashID)->first();

        $classifications = $request['group-a'];

        $classificationsPrice = [];

        foreach($classifications as $classification) {
            if(isset($classification['price'])) {
                $classificationsPrice[] = $classification['price'];
                DB::table('retail_classifications')->insert(
                    array(
                        'hashID' => Str::substr(Str::slug(Hash::make($outcome->shop . Carbon::now())), 0, 32),
                        'outcome_hash' => $hashID,
                        'classification_category' => $classification['classification_category'],
                        'classification_type' => $classification['classification_type'],
                        'date' => date('Y-m-d'),
                        'price' => $classification['price'],
                        'vat' => $classification['tax'],
                    )
                );
            }
        }
        $sumClass = array_sum($classificationsPrice);

        if($outcome->price = $sumClass) {
            $outcome->status = 'crosschecked';
            $outcome->save();

            Session::flash('message', '???? ?????????????????????? ???????????????????????????? ???? ????????????????');
        } else {
            Session::flash('message', '???? ?????????????????????????? ?????????????????????????? ???? ????????????????');
        }

        return back();
    }

    public function sendClassificationsMyData(Request $request) {
        //dd($request);
        $an = myDataSendExpensesClassification($request->outcome_hash);
        //dd($an);
        $theOutcome = Outcomes::query()->where('hashID', '=', $request->outcome_hash)->first();
        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
//                "index" => $aade->firstname,
//                "invoiceUid" => $aade->invoiceUid,
//                "invoiceMark" => $aade->invoiceMark,
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }
        dd($xml->response);
        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theOutcome->classified = 1;
            $theOutcome->save();
        } else {
            dd($aadeResponse[0]['statusCode']);
        }

        return redirect('/outcomes');
    }

    public function updateClassifications(Request $request, $hashID) {

        $outcome = Outcomes::query()->where('hashID', '=', $hashID)->first();

        $oldClassifications = $request['old'];
        $newClassifications = $request['group-a'];

        $newPrices = [];
        if($oldClassifications != null && count($oldClassifications) > 0) {
            foreach($oldClassifications as $old) {
                $newPrices[] = $old['price'];
                DB::table('retail_classifications')->where('hashID', '=', $old['classificationHash'])->update([
                    'classification_category' => $old['classification_category'],
                    'classification_type' => $old['classification_type'],
                    'updated_at' => date('Y-m-d'),
                    'price' => $old['price'],
                    'vat' => $old['tax']
                ]);
            }
        }

        if($newClassifications != null && count($newClassifications) > 0) {
            foreach($newClassifications as $classification) {
                $newPrices[] = $classification['price'];
                if(isset($classification['price'])) {
                    DB::table('retail_classifications')->insert(
                        array(
                            'hashID' => Str::substr(Str::slug(Hash::make($outcome->shop . Carbon::now())), 0, 32),
                            'outcome_hash' => $hashID,
                            'classification_category' => $classification['classification_category'],
                            'classification_type' => $classification['classification_type'],
                            'date' => date('Y-m-d'),
                            'price' => $classification['price'],
                            'vat' => $classification['tax'],
                        )
                    );
                }

            }
        }

        $newPrice = array_sum($newPrices);
        if($newClassifications != null) {
            if($oldClassifications[0]['tax'] == 8 || $newClassifications[0]['tax'] == 8){
                $outcome->status = 'efka';
            } elseif($newPrice = $outcome->price) {
                $outcome->status = 'crosschecked';
            } elseif(!$outcome->minMark && $newPrice = $outcome->price) {
                $outcome->status = 'uncrosschecked';
            } else {
                $outcome->status = 'presaved';
            }
            $outcome->save();
        }



        Session::flash('message', '???? ?????????????????????????? ???????????????????????? ???? ????????????????');
        return back();
    }

    public function deleteClassification(Request $request) {
        DB::table('retail_classifications')->where('hashID', $request->classification)->delete();
        return 'success';
    }
}
