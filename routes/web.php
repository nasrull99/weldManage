<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SalesController;
use App\Models\User;

use Illuminate\Support\Facades\Route;

// Public route for welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Grouped routes protected by 'auth' middleware
Route::middleware(['auth', 'verified', 'usertype:admin'])->group(function () {

    //Admin Dashboard
    Route::get('dashboard', [SalesController::class, 'index'])->name('dashboard');  

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
    Route::get('customertracker/{id}', [CustomerController::class, 'tracker'])->name('customer.tracker');
    Route::post('/tracker-edit{id}', [CustomerController::class, 'trackeredit'])->name('tracker.edit');
    Route::delete('/customer-tracker/{customer}/{index}', [CustomerController::class, 'deleteTrackerEntry'])->name('tracker.delete');

    
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
    Route::get('/edit-quotations/{id}', [QuotationController::class, 'edit'])->name('editQuotation');
    Route::put('/quotations/{id}', [QuotationController::class, 'update'])->name('updateQuotation');
    Route::get('/quotation/{id}', [QuotationController::class, 'generatePDF'])->name('pdfQuotation');
    Route::delete('/quotations/{quotation}/material/{material}', [QuotationController::class, 'removeMaterial'])
    ->name('quotation.removeMaterial');


    // Invoice Routes
    Route::get('/invoice-builder', [InvoicesController::class, 'index'])->name('showInvoices');
    Route::get('/tableinvoices', [InvoicesController::class, 'show'])->name('tableinvoice');
    Route::post('/invoices/save', [InvoicesController::class, 'store'])->name('invoices.save');
    Route::delete('/invoices/{id}', [InvoicesController::class, 'destroy'])->name('invoices.destroy');
    Route::get('invoices/{customerId}/{invoiceId}', [InvoicesController::class, 'viewCustomer'])->name('invoices.viewForCustomer');
    Route::get('/edit-invoices/{id}/', [InvoicesController::class, 'edit'])->name('editInvoice');
    Route::put('/invoices/{id}', [InvoicesController::class, 'update'])->name('updateInvoice');
    Route::delete('/invoice/{invoice}/material/{material}', [InvoicesController::class, 'removeMaterial'])->name('invoice.removeMaterial');    
    Route::get('/invoice/{id}', [InvoicesController::class, 'generatePDF'])->name('pdfInvoice');

    // Sales Report Routes
    Route::get('/sales-report', [SalesController::class, 'view'])->name('index.sales');
    Route::get('/sales-report/show', [SalesController::class, 'showSales'])->name('salesreport');
    Route::get('/sales-report/download', [SalesController::class, 'downloadSalesReport'])->name('salesreport.download');

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
    Route::get('/customer/quotation/{customerId}/{quotationId}', [QuotationController::class, 'custview'])->name('customer.quotations.view');

    Route::get('/customer/invoices', [InvoicesController::class, 'customerInvoices'])->name('customer.invoices');
    Route::get('/customer/invoices/{customerId}/{invoiceId}', [InvoicesController::class, 'custview'])->name('customer.invoices.view');

    Route::get('/customer/invoices', [InvoicesController::class, 'customerInvoices'])->name('customer.invoices');
    Route::get('/customer/change-password', [CustomerController::class, 'showChangePasswordForm'])->name('customer.changePasswordForm');
    Route::post('/customer/change-password', [CustomerController::class, 'changePassword'])->name('customer.changePassword');
});

// Authentication routes
require __DIR__.'/auth.php';
