<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Subscriptions extends Controller
{
    public function index() {
        $subscriptions = Subscriptions::all();

        return view('subscriptions.index', ['subscriptions' => $subscriptions]);
    }
}
