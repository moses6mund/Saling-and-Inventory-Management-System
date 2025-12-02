@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 font-weight-bold text-primary"><i class="fas fa-chart-line mr-2"></i>Profit Report of Pharmacy Store and Selling Management System</h4>

    <div class="row">
        <!-- Daily Profit -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong>Daily Profit (Last 30 Days)</strong>
                </div>
                <div class="card-body">
                    @forelse ($dailyProfit as $day)
                        <div class="d-flex justify-content-between small border-bottom py-1">
                            <span>{{ \Carbon\Carbon::parse($day->day)->format('M d, Y') }}</span>
                            <span><strong>Tsh {{ number_format($day->total_profit, 2) }}</strong></span>
                        </div>
                    @empty
                        <p class="text-muted">No daily profit data available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Monthly Profit -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong>Monthly Profit (Last 12 Months)</strong>
                </div>
                <div class="card-body">
                    @forelse ($monthlyProfit as $month)
                        <div class="d-flex justify-content-between small border-bottom py-1">
                            <span>{{ \Carbon\Carbon::parse($month->month . '-01')->format('F Y') }}</span>
                            <span><strong>Tsh {{ number_format($month->total_profit, 2) }}</strong></span>
                        </div>
                    @empty
                        <p class="text-muted">No monthly profit data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<a href="{{ Auth::user()->is_admin == 1 ? route('home') : route('welcome')}}" class="btn btn-outline-primary mr-5"> back home</a>
@endsection
