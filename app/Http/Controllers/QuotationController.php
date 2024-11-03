<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; 
use App\Models\Customer;
use App\Models\Quotation; 

class QuotationController extends Controller
{
    public function showQuotation()
    {
    $customers = Customer::all();
    $materials = Material::all();
    return view('quotation-builder', compact('customers', 'materials'));
    }

    public function show()
    {
    $quotations = Quotation::all();
    return view('tablequotation', compact('quotations'));
    }

}
