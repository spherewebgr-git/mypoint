{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Νέα Συνδρομή')

{{-- page styles --}}
@section('page-style')
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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Συνδρομές</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="/subscriptions">Συνδρομές</a>
                        </li>
                        <li class="breadcrumb-item active">Νέα Συνδρομή
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <div class="col xl9 m8 s12">
                <div class="card">
                    <div class="card-content px-36">
                        <form action="{{route('subscriptions.store')}}" method="post">
                            @csrf
                            <div class="input-field col s12 m6">
                                <select name="client" id="client" class="select2">
                                    <option value="0" disabled selected>Επιλέξτε Πελάτη</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->company}}</option>
                                    @endforeach
                                </select>
                                <label for="client">Πελάτης</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select name="service" id="service" class="select2">
                                    <option value="0" disabled selected>Επιλέξτε Υπηρεσία</option>
                                    <option value="Hosting">Φιλοξενία Ιστοσελίδας - Hosting</option>
                                    <option value="Hosting">Τεχνική Υποστήριξη Ιστοσελίδας</option>
                                </select>
                                <label for="service">Πελάτης</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <input type="text" id="price" name="price">
                                <label for="price">Ποσό</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <select name="renewal_period" id="renewal_period" class="select2">
                                    <option value="0" disabled selected>Επιλέξτε Περίοδο Χρέωσης</option>
                                    <option value="Ετησίως">Ετησίως</option>
                                    <option value="Μηνιαίως">Μηνιαίως</option>
                                    <option value="Διετία">Διετία</option>
                                    <option value="Τριετία">Τριετία</option>
                                </select>
                                <label for="renewal_period">Περίοδος Χρέωσης</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" class="datepicker" id="renewal_date" name="renewal_date">
                                <label for="renewal_date">Ημερομηνία Πρώτης Χρέωσης</label>
                            </div>
                            <div class="col s12 display-flex justify-content-center form-action mt-3 mb-4">
                                <button type="submit" class="btn indigo waves-effect waves-light">Αποθήκευση Αλλαγών</button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('last-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
    <script>
        $d = jQuery.noConflict();
        $d(document).ready(function(){
            // $d('.datepicker').timepicker({
            //     dateFormat: 'MM/YYYY'
            // });
        });
    </script>
@endsection
