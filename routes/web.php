<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//CUSTOMER
Route::get('/customer', function () {
    return view('customer');
    })->middleware(['auth', 'verified'])->name('customer');

Route::post('/tablecustomer', CustomerController::class .'@store')
    ->name('storecustomer')
    ->middleware(['auth', 'verified']);

Route::get('/tablecustomer', CustomerController::class .'@show')
    ->name('showname')
    ->middleware(['auth', 'verified']);

Route::get('/edit-customer/{id}', CustomerController::class .'@editview')
    ->name('editcustomer')
    ->middleware(['auth', 'verified']);

Route::post('/editsavedcustomer/{id}', CustomerController::class .'@editsaved')
    ->name('editsavedcust')
    ->middleware(['auth', 'verified']);

Route::delete('/destroycustomer/{id}', CustomerController::class .'@destroy')
    ->name('deletecustomer')
    ->middleware(['auth', 'verified']);

Route::get('pdf-customer', [CustomerController::class, 'pdfcustomer'])->name('pdfcustomer');

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

Route::get('pdf-material', [MaterialController::class, 'pdfmaterial'])->name('pdfmaterial');


//Quotation-builder
Route::get('/quotation-builder', [QuotationController::class, 'showQuotation'])
    ->name('showQuotation')
    ->middleware(['auth', 'verified']);

    Route::get('/tablequotation', function () {
        return view('tablequotation');
    })->middleware(['auth', 'verified'])->name('tablequotation');

//auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
