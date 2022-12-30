{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Συνδρομές')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Συνδρομών</span></h5>
                </div>
            </div>
        </div>
    </div>
<!-- BEGIN: Page Main-->
    <section class="invoice-list-wrapper section">

        <div class="card print-hide">
            <div class="card-content container display-flex">
                <!-- create invoice button-->
                <!-- Options and filter dropdown button-->
                <div class="invoice-filter-action mr-3">
                    <a href="#" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                        <i class="material-icons">picture_as_pdf</i>
                        <span class="hide-on-small-only">Export to PDF</span>
                    </a>
                </div>
                <!-- create invoice button-->
                <div class="invoice-create-btn">
                    <a href="app-invoice-add.html" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                        <i class="material-icons">add</i>
                        <span class="hide-on-small-only">Create Invoice</span>
                    </a>
                </div>
                <div class="filter-btn">
                    <!-- Dropdown Trigger -->
                    <a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
                       data-target='btn-filter'>
                        <span class="hide-on-small-only">Filter Invoice</span>
                        <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                    <!-- Dropdown Structure -->
                    <ul id='btn-filter' class='dropdown-content'>
                        <li><a href="#!">Paid</a></li>
                        <li><a href="#!">Unpaid</a></li>
                        <li><a href="#!">Partial Payment</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="responsive-table">
            <table class="table invoice-data-table white border-radius-4 pt-1">
                <thead>
                <tr>
                    <th><span>Πελάτης</span></th>
                    <th class="center">Υπηρεσία</th>
                    <th class="center">Ποσό</th>
                    <th class="center">Περίοδος Χρέωσης</th>
                    <th class="center">Ημ/νία Χρέωσης</th>
                    <th class="center">Τελευταία Πληρωμή</th>
                    <th class="center">Επόμενη Πληρωμή</th>
                    <th class="center">Ενέργειες</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscriptions as $subscription)
                <tr>
                    <td><a href="{{route('client.view', ['hashID' => getClient($subscription->client_id)['hashID']])}}">{{getClient($subscription->client_id)['company']}}</a></td>
                    <td class="center">{{$subscription->service}}</td>
                    <td class="center">&euro; {{number_format($subscription->renewal_price, '2', '.', ',')}}</td>
                    <td class="center">{{$subscription->renewal_period}}</td>
                    <td class="center">{{\Carbon\Carbon::createFromTimestamp(strtotime($subscription->renewal_date))->format('d/m')}}</td>
                    <td class="center">@if(isset($subscription->last_payed)) {{\Carbon\Carbon::createFromTimestamp(strtotime($subscription->last_payed))->format('d/m/Y')}} @endif</td>
                    <td class="center">{{subscriptionNextPayment($subscription->id)}}</td>
                    <td class="center">
                        <div class="invoice-action">
                            <a href="app-invoice-view.html" class="invoice-action-view mr-4">
                                <i class="material-icons">remove_red_eye</i>
                            </a>
                            <a href="app-invoice-edit.html" class="invoice-action-edit">
                                <i class="material-icons">edit</i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
<!-- END: Page Main-->
@endsection

