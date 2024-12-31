<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; 
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationMaterial;
use DB;

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
        // Validate the incoming data
        $request->validate([
            'customer_id' => 'required|exists:custdetail,id',
            'materials' => 'required|json', // Ensure the materials field is an array
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ]);

        // Decode the materials field from JSON
        $materials = json_decode($request->materials, true);

        // Start a transaction to ensure both the quotation and materials are saved together
        DB::beginTransaction();
        
        try {
            // Create a new quotation
            $quotation = Quotation::create([
                'customer_id' => $request->customer_id,
                'totalamount' => 0, // Initial total, we will calculate it later
            ]);
            
            $totalAmount = 0;

            // Save each material and calculate total amount
            foreach ($materials as $material) {
                $materialData = Material::find($material['material_id']);
                $amount = $materialData->price * $material['quantity'];
                
                // Save material to quotation_materials
                QuotationMaterial::create([
                    'quotation_id' => $quotation->id,
                    'material_id' => $material['material_id'],
                    'quantity' => $material['quantity'],
                    'amount' => $amount,
                ]);

                // Add amount to the total
                $totalAmount += $amount;
            }

            // Update the total amount in the quotation
            $quotation->update(['totalamount' => $totalAmount]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('tablequotation')->with('success', 'Quotation saved successfully!');
        } catch (\Exception $e) {
            // If something goes wrong, roll back the transaction
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function showQuotations()
    {
        $quotations = Quotation::with('customer')->get();
        return view('tablequotation', compact('quotations'));
    }

    public function viewForCustomer($customerId, $quotationId)
    {
        // Get the customer with quotations and materials
        $customer = Customer::with(['quotations' => function ($query) use ($quotationId) {
            $query->where('id', $quotationId)->with('materials');
        }])->findOrFail($customerId);

        $quotation = $customer->quotations->first(); // Assuming only one quotation is being passed

        return view('viewquotationCust', compact('customer', 'quotation'));
    }

}
