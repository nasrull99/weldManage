<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Pdf;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.dashboard');
    }

    public function index2()
    {
        $newCustomers = Customer::orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard', compact('newCustomers'));
    }

    public function pdfcustomer()
    {
        // Fetch customer data from the database (adjust according to your model)
        $customers = Customer::all();

        // Data to be passed to the view
        $data = [
            'title' => 'Customer List',
            'date' => now()->toDateString(),
            'image' => public_path('images/logoAMD.jpeg'),
            'content' => 'Here is the list of customers.',
            'customers' => $customers
        ];

        // Load the view and pass the data
        $pdf = Pdf::loadView('pdf-customer', $data);

        // Save PDF to storage or public folder
        $pdf->save(public_path('public.pdf'));

        // Optionally, return a download response
        return $pdf->download('List of Customers.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'location' => 'required|max:255',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'location' => $request->location,
            'status' => $request->status,
            'user_id' => Auth::id(), // Associate with the logged-in user
        ]);

        return redirect()->route('storecustomer')->with('success', 'Customer Add successfully.');
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
        return redirect()->route('showname')->with('success', 'Customer Edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('showname')->with('success', 'Customer deleted successfully');
    }
}
