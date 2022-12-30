<?php

namespace App\Http\Controllers;

use App\Models\Client;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubscriptionsController extends Controller
{
    public function index() {
        $subscriptions = Subscriptions::all();

        return view('subscriptions.index', ['subscriptions' => $subscriptions]);
    }

    public function create() {
        $clients = Client::all();

        return view('subscriptions.new', ['clients' => $clients]);
    }
    public function store(Request $request)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->renewal_date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->renewal_date);
        }

        $date = $requestDate->format('Y-m-d');

        DB::table('subscriptions')->insert(
            array(
                'client_id' => $request->client,
                'service' => $request->service,
                'renewal_period' => $request->renewal_period,
                'renewal_date' => $date,
                'renewal_price' => $request->price
            )
        );

        return redirect('/subscriptions');
    }
}
