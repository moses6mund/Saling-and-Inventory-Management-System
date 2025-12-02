<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Daily report
     */
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        $orders = Order::whereDate('created_at', $date)->get();

        $reportData = [];
        $totalAmount = 0;
        $totalQuantitySold = 0;

        foreach ($orders as $order) {
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();

            foreach ($orderDetails as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $totalQuantitySold += $detail->quantity;
                    $totalAmount += $detail->total_amount;

                    $reportData[] = [
                        'customer_name' => $order->name,
                        'product_name' => $product->product_name,
                        'quantity_sold' => $detail->quantity,
                        'unit_price' => $detail->unitprice,
                        'total_amount' => $detail->total_amount,
                    ];
                }
            }
        }

        return view('reports.index', [
            'reportData' => $reportData,
            'totalAmount' => $totalAmount,
            'totalQuantitySold' => $totalQuantitySold,
            'date' => $date
        ]);
    }

    /**
     * List orders & products
     */
    public function index()
    {
        $products = Product::all();
        $orders = Order::all();
        return view('orders.index', [
            'products' => $products, 
            'orders' => $orders
        ]);
    }

    /**
     * Profit Reports
     */
    public function profit()
    {
        $dailyProfit = Order::selectRaw('DATE(created_at) as day, SUM(profit) as total_profit')
            ->groupBy('day')
            ->orderBy('day', 'desc')
            ->take(30)
            ->get();

        $monthlyProfit = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(profit) as total_profit')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('profits.index', [
            'dailyProfit' => $dailyProfit,
            'monthlyProfit' => $monthlyProfit
        ]);
    }

    /**
     * Store a new order with correct profit calculation
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Create the order
            $order = new Order;
            $order->name = $request->customer_name;
            $order->address = $request->customer_phone;
            $order->profit = 0;
            $order->save();

            $totalSale = 0;
            $totalCost = 0;

            // Loop through each product added to the order
            for ($i = 0; $i < count($request->product_id); $i++) {

                $product = Product::find($request->product_id[$i]);

                if (!$product) {
                    DB::rollBack();
                    return back()->with('error', 'Product not found.');
                }

                // Final selling price after discount
                $unitPrice = $request->price[$i];
                $qty = $request->quantity[$i];
                $discount = $request->discount[$i];

                $finalAmount = ($unitPrice * $qty) - $discount;

                // Create order detail row
                $detail = new OrderDetail;
                $detail->order_id = $order->id;
                $detail->product_id = $product->id;
                $detail->unitprice = $unitPrice;
                $detail->quantity = $qty;
                $detail->discount = $discount;
                $detail->total_amount = $finalAmount;
                $detail->save();

                // Stock updates
                if ($product->quantity < $qty) {
                    DB::rollBack();
                    return back()->with('error', 'Not enough stock for ' . $product->product_name);
                }

                $product->quantity -= $qty;
                $product->save();

                // Add totals
                $totalSale += $finalAmount;
                $totalCost += $product->cost_price * $qty;
            }

            // Store transaction
            $transaction = new Transaction;
            $transaction->order_id = $order->id;
            $transaction->user_id = auth()->user()->id;
            $transaction->balance = $request->balance;
            $transaction->paid_amount = $request->paid_amount;
            $transaction->payment_method = $request->payment_method;
            $transaction->transac_amount = $totalSale;
            $transaction->transac_date = date('Y-m-d');
            $transaction->save();

            // Save final profit
            $order->profit = $totalSale - $totalCost;
            $order->save();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(Order::getStatuses())],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated.');
    }
}
