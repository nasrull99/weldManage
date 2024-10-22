<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'location' => 'required|max:255',
            'status' => 'required|string|in:pending,in_progress,completed', // Validate status
        ]);

        Customer::create($request->all());

        return redirect()->route('tablecustomer')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $customers = Customer::all();
        return view('tablecustomer', compact("customers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function editview(Request $request, string $id)
    {
        $customer = Customer::find($id);
        return view('edit-customer', compact('customer'));
    }

    public function editsaved(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->location = $request ->location;
        $customer->status = $request ->status;
        $customer->save();
        return redirect('tablecustomer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('tablecustomer')->with('success', 'Customer deleted successfully');
    }

    public function showQuotation()
    {
    // Fetch customers from the database
    $customers = Customer::all(); // Adjust this based on your database structure
    
    return view('quotation-builder', compact('customers'));// Pass the customers to the view
    }

}
