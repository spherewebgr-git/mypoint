<?php


use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;


// Subscriptions Routes
Route::name('subscriptions.')->prefix('/')->group(function () {
    Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('list');
    Route::get('/new-subscription', [SubscriptionsController::class, 'create'])->name('create');
    Route::post('/store-subscription', [SubscriptionsController::class, 'store'])->name('store');
    Route::get('/view-subscription', [SubscriptionsController::class, 'show'])->name('view');
    Route::post('/update-subscription/', [SubscriptionsController::class, 'update'])->name('update');
});
