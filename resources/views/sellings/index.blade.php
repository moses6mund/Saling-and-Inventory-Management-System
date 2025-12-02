@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-shopping-cart mr-2"></i> Sales History
                        </h5>
                        <div class="btn-group">
                            <a href="{{ Auth::user()->is_admin == 1 ? route('home') : route('welcome')}}" class="btn btn-outline-primary btn-sm px-2">
                                Back Home
                            </a>
                            <button type="button" class="btn btn-outline-primary btn-sm px-2" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Print Sales
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Date Range Filter Form -->
                    <form id="date-filter-form" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary mt-4" onclick="filterSales()">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Sales Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Unit Price (Tsh)</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-right">Total Amount (Tsh)</th>
                                    <th>Customer</th>
                                    <th>Address</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orderDetails as $index => $orderDetail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="small text-muted">
                                                {{ \Carbon\Carbon::parse($orderDetail->transac_date)->format('M d, Y') }}
                                            </div>
                                            <div class="small">
                                                {{ \Carbon\Carbon::parse($orderDetail->transac_date)->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-capsules text-primary mr-2"></i>
                                                <span>{{ $orderDetail->product->product_name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-pill badge-info">
                                                {{ $orderDetail->quantity }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            Tsh {{ number_format($orderDetail->unitprice, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @if($orderDetail->discount > 0)
                                                <span class="badge badge-success">
                                                    {{ $orderDetail->discount }} Tsh
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">0 Tsh</span>
                                            @endif
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            Tsh {{ number_format($orderDetail->total_amount, 2) }}
                                        </td>
                                        <td>
                                            <i class="fas fa-user-circle text-secondary mr-2"></i>
                                            {{ $orderDetail->order->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                                            {{ $orderDetail->order->address ?? 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $orderDetail->order->status == 'completed' ? 'success' : ($orderDetail->order->status == 'rejected' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($orderDetail->order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            
                                            <form action="{{ route('orders.updateStatus', $orderDetail->order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>

                                            <form action="{{ route('orders.updateStatus', $orderDetail->order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger btn-sm">Dept</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                                <h5 class="font-weight-light text-muted">No sales records found</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="6" class="text-right font-weight-bold">Total Sales:</td>
                                    <td class="text-right font-weight-bold text-primary">
                                        Tsh {{ number_format($orderDetails->sum('total_amount'), 2) }}
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Scripts Section --}}
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script>
    function filterSales() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            const transactionDateText = row.cells[1].querySelector('.small').textContent.trim();
            const transactionDate = moment(transactionDateText, 'MMM DD, YYYY').format('YYYY-MM-DD');

            if (isDateInRange(transactionDate, startDate, endDate)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function isDateInRange(transactionDate, startDate, endDate) {
        if (!startDate && !endDate) return true;
        if (startDate && endDate) return transactionDate >= startDate && transactionDate <= endDate;
        if (startDate) return transactionDate >= startDate;
        if (endDate) return transactionDate <= endDate;
        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof moment === 'undefined') {
            console.error('Moment.js is not loaded.');
        }
    });
</script>
@endpush
