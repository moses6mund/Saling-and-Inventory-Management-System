<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the 5 most recent products
        $recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();

        // Get all order details
        $orderDetails = OrderDetail::with(['order', 'product'])->get();

        // Calculate the total sale amount across all order details
        $totalSaleAmount = $orderDetails->sum(function ($orderDetail) {
            return $orderDetail->product->price * $orderDetail->quantity;
        });

        // Find the total amount of today
        $orderDetailsToday = OrderDetail::with(['order', 'product'])
            ->whereDate('created_at', Carbon::today())
            ->get();

        $totalSaleAmountToday = $orderDetailsToday->sum(function ($orderDetail) {
            return $orderDetail->product->price * $orderDetail->quantity;
        });

        // Find the total amount of the most recent order date
        $latestOrder = Order::latest('created_at')->first();

        if ($latestOrder) {
            $latestOrderDate = $latestOrder->created_at->toDateString();
        } else {
            $latestOrderDate = null; // Or provide a default value if needed
        }

        $orderDetailsLastDay = OrderDetail::with(['order', 'product'])
            ->whereDate('created_at', $latestOrderDate)
            ->get();

        $totalSaleAmountLastDay = $orderDetailsLastDay->sum(function ($orderDetail) {
            return $orderDetail->product->price * $orderDetail->quantity;
        });

        // Create a monthly sales chart
        $salesByMonth = OrderDetail::selectRaw('MONTH(order_details.created_at) as month, SUM(order_details.quantity * products.price) as total_sales')
            ->join('products', 'order_details.product_id', '=', 'products.id') // join the products table to get the price
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Data for the chart
        $months = $salesByMonth->pluck('month');
        $sales = $salesByMonth->pluck('total_sales');

        // Create the chart
        $chart = new Chart;

        // Set the chart labels dynamically based on months data
        $chart->labels($months->map(function ($month) {
            // Mapping month number to the month name
            return Carbon::createFromFormat('m', $month)->format('F');
        }));

        // Add the dataset for sales data
        $chart->dataset('Sales', 'line', $sales)
            ->options([
                'borderColor' => 'rgba(255, 99, 132, 1)',  // Border color
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',  // Background color
                'borderWidth' => 2  // Border width
            ]);

        // Optional: add another dataset for comparison
        $chart->dataset('Sales 2', 'line', [5, 15, 25, 35])  // Static data for second dataset
            ->options([
                'borderColor' => 'rgba(54, 162, 235, 1)',  // Border color
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',  // Background color
                'borderWidth' => 2  // Border width
            ]);

        return view('home', [
            'orderDetails' => $orderDetails,
            'totalSaleAmount' => $totalSaleAmount,
            'totalSaleAmountToday' => $totalSaleAmountToday,
            'totalSaleAmountLastDay' => $totalSaleAmountLastDay,
            'recentProducts' => $recentProducts,
            'chart' => $chart,  // Pass the chart to the view
            'sales' => $sales, // Pass sales to the view
            'months' => $months  // Pass months to the view
        ]);
    }
}
