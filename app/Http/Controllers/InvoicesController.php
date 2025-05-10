<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; 
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceMaterial;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function generatePDF($id)
    {
        // Find the quotation by ID
        $invoice = Invoice::findOrFail($id);

        // Retrieve the associated customer information (assuming you have a relationship set up)
        $customer = $invoice->customer;

        // Load the PDF view, passing both quotation and customer data
        $pdf = Pdf::loadView('pdf-Invoice', compact('invoice', 'customer'));

        // Return the PDF as a download
        return $pdf->download('invoice_'.$customer->name.'_ID_'.$invoice->id.'.pdf');
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

        //Check if customer already has a invoice
        $existingInvoice = Invoice::where('customer_id', $request->customer_id)->first();
        if ($existingInvoice ) {
            return redirect()->back()->with('error', 'This customer already has a Invoice.');
        }

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
            $totalAmount = $request->subtotal - $request->deposit;
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
        $invoice = Invoice::with('materials')->findOrFail($id);
        $materials = Material::all();

        return view('edit-invoice', compact('invoice', 'materials'));
    }

    
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:materials,id', // Material ID must exist in the materials table
            'materials.*.quantity' => 'required|integer|min:1', // Quantity must be greater than or equal to 1
            'updatesubtotalinvoice' => 'required|numeric|min:0', // Subtotal validation
            'updatenewdeposit' => 'required|numeric|min:0', // Deposit validation
            'updatetotalamountinvoice' => 'required|numeric|min:0', // Total amount validation
        ]);
    
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);
    
        // Get the updated values from the request
        $materials = $request->input('materials', []);
        $subtotal = $request->input('updatesubtotalinvoice');
        $deposit = $request->input('updatenewdeposit');
        $totalAmount = $request->input('updatetotalamountinvoice');
    
        // Prepare data for syncing materials
        $data = [];
        foreach ($materials as $material) {
            // Calculate amount for each material based on quantity and price
            $amount = Material::find($material['id'])->price * $material['quantity'];
            
            $data[$material['id']] = [
                'quantity' => $material['quantity'],
                'amount' => $amount,
            ];
        }
    
        // Start a DB transaction to ensure consistency
        DB::beginTransaction();
    
        try {
            // Sync the materials with the updated quantities and amounts
            $invoice->materials()->sync($data);
    
            // Update the invoice with the new subtotal, deposit, and total amount
            $invoice->update([
                'subtotal' => $subtotal,
                'deposit' => $deposit,
                'totalamount' => $totalAmount, // Total amount is calculated as subtotal - deposit
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Redirect back with success message
            return redirect()->route('tableinvoice')->with('success', 'Invoice updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of failure
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }
    

    
    public function destroy($id)
    {
        // Start a DB transaction
        DB::beginTransaction();

        try {
            // Find the invoice
            $invoice = Invoice::findOrFail($id);

            // Delete related invoice materials
            InvoiceMaterial::where('invoice_id', $invoice->id)->delete();

            // Delete the invoice itself
            $invoice->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->route('tableinvoice')->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Delete failed: ' . $e->getMessage()]);
        }
    }

    public function viewCustomer($customerId, $invoiceId)
    {
        // Get the customer with the specific invoice and its materials
        $customer = Customer::with(['invoices' => function ($query) use ($invoiceId) {
            $query->where('id', $invoiceId)->with('materials');
        }])->findOrFail($customerId);

        $invoice = $customer->invoices->first(); // Assuming only one invoice is passed

        return view('viewinvoiceCust', compact('customer', 'invoice'));
    }

    public function removeMaterial($invoiceId, $materialId)
    {
        try {
            // Find the invoice
            $invoice = Invoice::findOrFail($invoiceId);

            // Detach the material from the invoice
            $invoice->materials()->detach($materialId);

            return response()->json(['success' => true, 'message' => 'Material removed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove material: ' . $e->getMessage()], 500);
        }
    }

    public function customerInvoices()
    {
        $user = auth()->user(); // Get logged-in user

        // Find the customer record associated with the logged-in user
        $customer = Customer::where('user_id', $user->id)->firstOrFail();

        // Fetch only the latest quotation for this customer
        $invoice = Invoice::where('customer_id', $customer->id)
                            ->with('materials')
                            ->latest()
                            ->first();

        if (!$invoice) {
            return redirect()->route('customer.dashboard')->with('error', 'No invoice found for this customer');
        }

        return view('customer.invoice', compact('customer', 'invoice'));
    }

}
