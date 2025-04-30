<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; 
use App\Models\Customer;
use App\Models\invoice;
use App\Models\InvoiceMaterial;
use DB;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $materials = Material::all();
        return view('invoice-builder', compact('customers', 'materials'));
    }

    public function show()
    {
        $invoices = Invoice::with('customer')->get();
        return view('tableinvoices', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'customer_id' => 'required|string|max:255',
            'materials' => 'required|json',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric',
            'deposit' => 'required|numeric',
        ]);

        // Decode the materials field from JSON
        $materials = json_decode($request->materials, true);

        // Start a transaction to ensure both the invoice and materials are saved together
        DB::beginTransaction();
        
        try {
            // Create a new invoice
            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'subtotal' => $request->subtotal,
                'deposit' => $request->deposit,
                'totalamount' => 0, // Initial total, will calculate it later
            ]);
            
            $totalAmount = 0;

            // Save each material and calculate total amount
            foreach ($materials as $material) {
                $materialData = Material::find($material['material_id']);
                $amount = $materialData->price * $material['quantity'];
                
                // Save material to invoice_materials
                InvoiceMaterial::create([
                    'invoice_id' => $invoice->id,
                    'material_id' => $material['material_id'],
                    'quantity' => $material['quantity'],
                    'amount' => $amount,
                ]);

                // Add amount to the total
                $totalAmount += $amount;
            }

            // Update the total amount in the invoice
            $invoice->update(['totalamount' => $totalAmount]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('tableinvoice')->with('success', 'Invoice saved successfully!');
        } catch (\Exception $e) {
            // If something goes wrong, roll back the transaction
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the invoice by its ID with related materials
        $invoice = invoice::with('materials')->findOrFail($id);

        // Retrieve all available materials from the database
        $materials = Material::all(); // This ensures $materials is defined

        // Pass data to the view
        return view('edit-invoice', compact('invoice', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = invoice::findOrFail($id);
        $materials = $request->input('materials', []);
        $totalAmount = 0;

        $data = [];
        foreach ($materials as $material) {
            $materialData = Material::findOrFail($material['id']);
            $price = $materialData->price;
            $quantity = $material['quantity'];
            $amount = $price * $quantity;

            $data[$material['id']] = [
                'quantity' => $quantity,
                'amount' => $amount,
            ];

            $totalAmount += $amount;
        }

        // Sync the materials with the calculated data
        $invoice->materials()->sync($data);

        // Update total amount in the invoice
        $invoice->totalamount = $totalAmount;
        $invoice->save();

        return redirect()->route('tableinvoice')->with('success', 'invoice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice = invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('tableinvoice')->with('success', 'invoice deleted successfully.');
    }
}
