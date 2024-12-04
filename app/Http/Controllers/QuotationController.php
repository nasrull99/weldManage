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

    public function save(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric',
        ]);

        // Create a new quotation entry
        Quotation::create([
            'customer_name' => $request->customer_name,
            'material' => $request->material,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
        ]);

        return response()->json(['success' => true]);
    }
    
}
