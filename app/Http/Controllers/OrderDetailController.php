<?php

namespace App\Http\Controllers;

use App\Exports\GenericExport;
use App\Imports\GenericImport;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Fetch all OrderDetails with related Order and Product
    $orderDetails = OrderDetail::with(['order', 'product'])->get();

    // Pass the orderDetails to the view
    return view('sellings.index', ['orderDetails' => $orderDetails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function orderDetailExport()
    {
        $columns = [

        ];

        $headings = [

        ];

        return Excel::download(
        new GenericExport(
        OrderDetail::class, $columns, $headings), 
        'orderdetail.csv');
    }

    public function orderDetailImport(Request $request)
    {
        $request->validate([
        '' => 'required|mimes:xlsl,csv'
        ]);
        $file = $request->file('file');

        Excel::import(
            new GenericImport(OrderDetail::class), $file
        );
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
}
