<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\Material;
use App\Models\Quotation;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pdf;

class CustomerController extends Controller
{

    public function index()
    {
        $customerCount = Customer::count();
        $materialCount = Material::count();
        $quotationCount = Quotation::count();
        // $invoiceCount = Invoice::count();
        $newCustomers = Customer::orderBy('created_at', 'desc')->take(5)->get();

        // $monthlyIncome = DB::table('totalsales')
        // ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
        // ->groupBy(DB::raw('MONTH(created_at)'))
        // ->orderBy('month', 'asc')
        // ->get();

        return view('dashboard', compact('customerCount', 'newCustomers', 'materialCount', 'quotationCount'));
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

        // **1. Create User Account**
        $user = User::create([
            'name' => $request->name,
            'email' => strtolower(str_replace(' ', '', $request->name)) . '@gmail.com', // Generate email
            'password' => Hash::make('12345678'), // Default password
            'usertype' => 'user',
        ]);

        // **2. Create Customer Details & Link with User**
        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'location' => $request->location,
            'status' => $request->status,
            'user_id' => $user->id, // Link to created user
        ]);

        return redirect()->route('showname')->with('success', 'Customer registered successfully.');
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
    
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ensure only customers access this
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // Fetch customer details based on user_id
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            return redirect()->route('showname')->with('error', 'Customer details not found.');
        }

        return view('customer.dashboard', compact('customer'));
    }
}
