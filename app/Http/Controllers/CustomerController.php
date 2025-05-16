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

    public function tracker($id)
    {
        // Fetch customer details based on user_id
        $customer = Customer::find($id);

        return view('customer-tracker', compact('customer'));
    }

    public function trackeredit(Request $request, string $id)
    {
        $customer = Customer::find($id);

        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,mp4,avi,mov,wmv|max:51200',   
        ]);

        // Prepare new entry
        $newEntry = [
            'datetime' => $request->filled('date') && $request->filled('time')
                ? $request->date . ' ' . $request->time
                : ($request->filled('date') ? $request->date : null),
            'description' => $request->description,
            'image' => null,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $newEntry['image'] = $request->file('image')->store('customer_images', 'public');
        }

        // Get existing history or initialize
        $history = $customer->description ? json_decode($customer->description, true) : [];

        // Only add if at least one field is filled
        if ($newEntry['datetime'] || $newEntry['description'] || $newEntry['image']) {
            $history[] = $newEntry;
        }

        // Save as JSON
        $customer->description = json_encode($history);

        $customer->save();

        return redirect()->back()->with('success', 'successfully.');
    }

    public function deleteTrackerEntry($customerId, $index)
    {
        $customer = Customer::findOrFail($customerId);
        $history = $customer->description ? json_decode($customer->description, true) : [];
        if (is_array($history) && isset($history[$index])) {
            // Optionally: delete the image file from storage
            if (!empty($history[$index]['image'])) {
                \Storage::disk('public')->delete($history[$index]['image']);
            }
            array_splice($history, $index, 1);
            $customer->description = json_encode($history);
            $customer->save();
        }
        return redirect()->back()->with('success', 'Tracker entry deleted successfully.');
    }
}
