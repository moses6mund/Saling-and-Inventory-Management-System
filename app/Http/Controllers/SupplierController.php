<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::paginate();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $supplier = Supplier::create([
            'supplier_name' =>$request->supplier_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        if($supplier){
            return back()->with('Success', 'Supplier created succesfully');

        }
        return back()->with('Error','supplier is not created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier = $supplier->delete();
        if($supplier){
            return back()->with('error', 'supplier is deleted ');
        }

        return back()->with('success', 'supplier is not deleted');
    }
}
