<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/customer', function () {
    return view('customer');
})->middleware(['auth', 'verified'])->name('customer');

//CUSTOMER
Route::post('/tablecustomer', CustomerController::class .'@store')
->name('storedata')->middleware(['auth', 'verified']);

Route::get('/tablecustomer', CustomerController::class .'@show')
->name('showname')->middleware(['auth', 'verified']);

Route::get('/edit-customer/{id}', CustomerController::class .'@editview')
->name('edit')->middleware(['auth', 'verified']);

Route::post('/editsavedcustomer/{id}', CustomerController::class .'@editsaved')
    ->name('editsavedcust')
    ->middleware(['auth', 'verified']);

    Route::delete('/destroycustomer/{id}', CustomerController::class .'@destroy')
    ->name('deletecustomer')
    ->middleware(['auth', 'verified']);

//MATERIAL
Route::get('/addmaterial', function () {
    return view('addmaterial');
})->middleware(['auth', 'verified'])->name('addmaterial');

Route::get('/tablematerial', MaterialController::class .'@showmaterial')
->name('tablematerial')->middleware(['auth', 'verified']);

Route::post('/tablematerial', MaterialController::class .'@storematerial')
->name('storematerial')->middleware(['auth', 'verified']);

Route::get('/edit-material/{id}', MaterialController::class .'@editviewmaterial')
->name('editmaterial')->middleware(['auth', 'verified']);

Route::post('/editsavedmaterial/{id}', MaterialController::class .'@editsavedmaterial')
->name('editsavedmaterial')->middleware(['auth', 'verified']);

Route::delete('/destroymaterial/{id}', MaterialController::class .'@destroymaterial')
    ->name('destroymaterial')
    ->middleware(['auth', 'verified']);

//Quotation-builder
Route::get('/quotation-builder', function () {
    return view('quotation-builder');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/quotation-builder', [CustomerController::class, 'showQuotation'])->name('showQuotation');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
