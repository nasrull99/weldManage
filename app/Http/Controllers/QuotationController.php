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

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric',
        ]);

        // Get material data
        $material = Material::find($request->material_id);
        $price = $material->price;

        // Save quotation to database
        Quotation::create([
            'customer_id' => $request->customer_id,
            'material_id' => $request->material_id,
            'quantity' => $request->quantity,
            'amount' => $price * $request->quantity,
        ]);

        return redirect()->route('quotation.create')->with('success', 'Quotation saved successfully!');
    }
    
}
