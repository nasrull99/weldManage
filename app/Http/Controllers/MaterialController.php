<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; 
use Barryvdh\DomPDF\Facade\Pdf;

class MaterialController extends Controller
{
    public function pdfmaterial()
    {
        // Fetch customer data from the database (adjust according to your model)
        $materials = Material::all();

        // Data to be passed to the view
        $data = [
            'title' => 'Customer List',
            'date' => now()->toDateString(),
            'image' => public_path('images/welcomebg.jpg'), // Adjust the image path if necessary
            'content' => 'Here is the list of customers.',
            'materials' => $materials
        ];

        // Load the view and pass the data
        $pdf = Pdf::loadView('pdf-material', $data);

        // Save PDF to storage or public folder
        $pdf->save(public_path('public.pdf'));

        // Optionally, return a download response
        return $pdf->download('Materials.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storematerial(Request $request)
    {
        $request->validate([
            'material' => 'required|max:255',
            'price' => 'required|numeric|between:0,99999.99',
        ]);

        Material::create($request->all());

        return redirect()->route('tablematerial')
            ->with('success', 'Material Add successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function showmaterial()
    {
        $materials = Material::all();
        return view('tablematerial', compact("materials"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function editviewmaterial(Request $request, string $id)
    {
        $material = Material::find($id);
        return view('edit-material', compact('material'));
    }

    public function editsavedmaterial(Request $request, string $id)
    {
        $material = Material::find($id);
        $material->material = $request->material;
        $material->price = $request->price;
        $material->save();
        return redirect()->route('tablematerial')->with('success', 'Material Edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroymaterial(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('tablematerial')->with('success', 'Material deleted successfully');
    }
}
