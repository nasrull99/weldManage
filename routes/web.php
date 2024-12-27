<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuotationController;
use App\Models\User;

use Illuminate\Support\Facades\Route;

// Public route for welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//Admin Dashboard
Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified','usertype:admin'])->name('dashboard');

// Customer View
Route::get('customer/dashboard', [CustomerController::class, 'index'])
->middleware(['auth','verified','usertype:user'])->name('customer.dashboard');

// Grouped routes protected by 'auth' middleware
Route::middleware(['auth','verified'])->group(function () {

    //Customer Admin view 
    Route::get('/customer', function () {
        return view('customer');
        })->name('customer');
    Route::post('/tablecustomer', [CustomerController::class, 'store'])->name('storecustomer');
    Route::get('/tablecustomer', [CustomerController::class, 'show'])->name('showname');
    Route::get('/edit-customer/{id}', [CustomerController::class, 'editview'])->name('editcustomer');
    Route::post('/editsavedcustomer/{id}', [CustomerController::class, 'editsaved'])->name('editsavedcust');
    Route::delete('/destroycustomer/{id}', [CustomerController::class, 'destroy'])->name('deletecustomer');
    Route::get('pdf-customer', [CustomerController::class, 'pdfcustomer'])->name('pdfcustomer');

    // Material Routes
    Route::get('/addmaterial', function () {
        return view('addmaterial');
        })->name('addmaterial');
    Route::get('/tablematerial', [MaterialController::class, 'showmaterial'])->name('tablematerial');
    Route::post('/tablematerial', [MaterialController::class, 'storematerial'])->name('storematerial');
    Route::get('/edit-material/{id}', [MaterialController::class, 'editviewmaterial'])->name('editmaterial');
    Route::post('/editsavedmaterial/{id}', [MaterialController::class, 'editsavedmaterial'])->name('editsavedmaterial');
    Route::delete('/destroymaterial/{id}', [MaterialController::class, 'destroymaterial'])->name('destroymaterial');
    Route::get('pdf-material', [MaterialController::class, 'pdfmaterial'])->name('pdfmaterial');

    // Quotation Routes
    Route::get('/quotation-builder', [QuotationController::class, 'showQuotation'])->name('showQuotation');
    Route::get('/tablequotation', function () {
        return view('tablequotation');
        })->name('tablequotation');
    Route::post('/quotations/save', [QuotationController::class, 'store'])->name('quotation.save');

    // Invoice Routes
    Route::get('/tableinvoices', function () {
        return view('tableinvoices');
        })->name('tableinvoicesView');

    // Sales Report Routes
    Route::get('/salesreport', function () {
        return view('salesreport');
        })->name('salesreportView');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user-list', [ProfileController::class, 'userList'])->name('userList');
    Route::get('/add-user', [ProfileController::class, 'adduser'])->name('adduser');
    Route::delete('/users/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

});

// Authentication routes
require __DIR__.'/auth.php';
