@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-2"></i>Sales Report
                            <span class="text-muted font-weight-normal ml-1">{{ $date }}</span>
                        </h5>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase mb-1">Total Sales</h6>
                                            <h2 class="mb-0">Tsh {{ number_format($totalAmount, 2) }}</h2>
                                        </div>
                                        <div class="float-right">
                                            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase mb-1">Total Quantity Sold</h6>
                                            <h2 class="mb-0">{{ number_format($totalQuantitySold) }} Units</h2>
                                        </div>
                                        <div class="float-right">
                                            <i class="fas fa-boxes fa-2x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Customer</th>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle text-center">Quantity</th>
                                    <th class="align-middle text-right">Unit Price (Tsh)</th>
                                    <th class="align-middle text-right">Total Amount (Tsh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportData as $index => $data)
                                    <tr>
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle text-secondary mr-2"></i>
                                                {{ $data['customer_name'] }}
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-capsules text-primary mr-2"></i>
                                                <span class="font-weight-medium">
                                                    {{ $data['product_name'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-pill badge-info">
                                                {{ number_format($data['quantity_sold']) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-right">
                                            Tsh {{ number_format($data['unit_price'], 2) }}
                                        </td>
                                        <td class="align-middle text-right font-weight-bold">
                                            Tsh {{ number_format($data['total_amount'], 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                                <h5 class="font-weight-light text-muted">No sales data available</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">Totals:</td>
                                    <td class="text-center font-weight-bold">
                                        {{ number_format($totalQuantitySold) }}
                                    </td>
                                    <td></td>
                                    <td class="text-right font-weight-bold text-primary">
                                        Tsh {{ number_format($totalAmount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <a href="{{ Auth::user()->is_admin == 1 ? route('home') : route('welcome') }}" class="btn btn-outline-primary btn-sm">
                            Back Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-pill {
        padding-right: 1em;
        padding-left: 1em;
    }
    
    .font-weight-medium {
        font-weight: 500;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,.04);
    }
    
    .card {
        border: none;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .opacity-50 {
        opacity: 0.5;
    }

    @media print {
        .btn-group {
            display: none;
        }
        .card {
            box-shadow: none !important;
        }
    }
</style>
@endsection