<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quotation', function () {
    return view('quotation');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/customer', function () {
    return view('customer');
})->middleware(['auth', 'verified'])->name('customer');

Route::post('/tablecustomer', CustomerController::class .'@store')->name('storedata');

Route::get('/tablecustomer', CustomerController::class .'@show')->name('tablecustomer');

Route::get('/edit-customer/{id}', CustomerController::class .'@editview')->name('edit');

Route::post('/editsaved/{id}', CustomerController::class .'@editsaved')->name('editsaved');

Route::delete('/destroy/{id}', CustomerController::class .'@destroy')->name('destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
