<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;  

class MaterialController extends Controller
{
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storematerial(Request $request)
    {
        $request->validate([
            'material' => 'required|max:255',
            'price' => 'required|numeric',
        ]);

        Material::create($request->all());

        return redirect()->route('tablematerial')
            ->with('success', 'Customer created successfully.');
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
        return redirect('tablematerial');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroymaterial(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('tablematerial')->with('success', 'Customer deleted successfully');
    }
    
}
