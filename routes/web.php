<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;

Route::get('/', [OfferController::class, 'index'])->name('offers.index');
Route::get('offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
Route::middleware('auth')->post('offers/{offer}', [OfferController::class, 'apply'])->name('offers.apply');
