<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(200);

        return view('products.index', ['products' => $products]);
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
        $request->validate([
            'product_name' => [
                'required',
                'string',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(product_name) = ?', [strtolower($request->product_name)]);
                }),
            ],
            'description' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'alert_stock' => 'required'

            
        ]);

        $products =Product::create([
            'product_name' => trim($request->product_name),
            'description' => trim($request->description),
            'brand' => trim($request->brand),
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'quantity' => $request->quantity,
            'alert_stock' => $request->alert_stock,

        ]);
        if($products){
            return redirect()->back()->with('success', 'Product Created Successfully');
        }
        return redirect()->back()->with('error', 'Failed To Create Product');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        if(!$product){
            return back()->with('Error','fail to update product');
        }
        
        return back()->with('Success', 'Product Updated Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
        $products = $product->delete();
        if(!$products){
            return back()->with('Error','User not foun');
        }
        return back()->with('Success', 'Product Deleted Successfull');
    }

    public function export()
    {
        $products = DB::table('products')->get();

        $fileName = 'products_export.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'id','product_name','description','brand','price',
                'cost_price','quantity','alert_stock','created_at','updated_at'
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->product_name,
                    $product->description,
                    $product->brand,
                    $product->price,
                    $product->cost_price,
                    $product->quantity,
                    $product->alert_stock,
                    $product->created_at,
                    $product->updated_at,
                ]);
            }

            fclose($file);
        };

        return back()->with('products.index',[
            'products' => $products,
            'headers' => $headers
        ]);
    }

    public function import(Request $request)
    {
        dd($request->all());
    }
}
