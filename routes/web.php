<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoicesController;
use App\Models\User;

use Illuminate\Support\Facades\Route;

// Public route for welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//Admin Dashboard
Route::get('dashboard', [CustomerController::class, 'index'])
    ->middleware(['auth', 'verified', 'usertype:admin'])
    ->name('dashboard');

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
    Route::post('/quotations/save', [QuotationController::class, 'store'])->name('quotation.save');
    Route::get('/tablequotation', [QuotationController::class, 'showQuotations'])->name('tablequotation');
    Route::get('quotation/{customerId}/{quotationId}', [QuotationController::class, 'viewForCustomer'])->name('viewForCustomer');
    Route::delete('/quotations/{id}', [QuotationController::class, 'destroy'])->name('deleteQuotation');
    Route::get('/quotations/{id}/edit', [QuotationController::class, 'edit'])->name('editQuotation');
    Route::put('/quotations/{id}', [QuotationController::class, 'update'])->name('updateQuotation');
    Route::get('/quotation/{id}', [QuotationController::class, 'generatePDF'])->name('pdfQuotation');

    // Invoice Routes
    Route::get('/invoice-builder', [InvoicesController::class, 'index'])->name('showInvoices');
    Route::get('/tableinvoices', [InvoicesController::class, 'show'])->name('tableinvoice');
    Route::post('/invoices/save', [InvoicesController::class, 'store'])->name('invoices.save');

    

    // Sales Report Routes
    Route::get('/salesreport', function () {
        return view('salesreport');
        })->name('salesreportView');
    Route::get('/sales-report', function () {
        return view('salesreportPage');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user-list', [ProfileController::class, 'userList'])->name('userList');
    Route::get('/add-user', [ProfileController::class, 'adduser'])->name('adduser');
    Route::delete('/users/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

});


// Customer View
Route::middleware(['auth', 'verified', 'usertype:user'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/customer/quotations', [QuotationController::class, 'customerQuotations'])->name('customer.quotations');
});

// Authentication routes
require __DIR__.'/auth.php';
