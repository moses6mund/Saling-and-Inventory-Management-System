@extends('layouts.app')

@section('content')
<div class="container custom mt-4">
    <div class="row">
        <!-- Order Form Card -->
        <div class="col-12 col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header custom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-shopping-cart mr-2"></i>Create Order
                        </h5>
                        @if (auth()->user()?->is_admin == 1)
                            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                                Home
                            </a>
                        @else
                            <a href="{{ route('welcome') }}" class="btn btn-outline-primary btn-sm">
                                Back Home
                            </a>
                        @endif

                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th width="30%">Product Name</th>
                                        <th class="text-center" width="15%">Quantity</th>
                                        <th class="text-right" width="15%">Selling Price (Tsh)</th>
                                        <th class="text-right d-none" width="15%">Cost Price (Tsh)</th>
                                        <th class="text-center" width="15%">Discount (Tsh)</th>
                                        <th class="text-right" width="15%">Total (Tsh)</th>
                                        <th class="text-right d-none" width="15%">Profit (Tsh)</th>
                                        <th class="text-center" width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody class="addMoreProduct">
                                    <tr>
                                        <td class="text-center no">1</td>
                                        <td>
                                            <select class="form-control product_id" name="product_id[]" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-cost="{{ $product->cost_price }}">
                                                        {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="quantity[]" class="form-control quantity text-center" value="1" min="1"></td>
                                        <td><input type="number" name="price[]" class="form-control price text-right" value="0.00" readonly></td>
                                        <td class="d-none"><input type="number" name="cost_price[]" class="form-control cost_price text-right" value="0.00" readonly></td>
                                        <td><input type="number" name="discount[]" class="form-control discount text-center" value="0"></td>
                                        <td><input type="number" name="total_amount[]" class="form-control total_amount text-right" value="0.00" readonly></td>
                                        <td class="d-none"><input type="number" name="profit[]" class="form-control profit text-right" value="0.00" readonly></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-success btn-sm rounded-circle add_more"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Card -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header custom py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-file-invoice mr-2"></i>Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Total Amount</label>
                        <div class="h3 mb-3 font-weight-bold text-primary">Tsh <span class="total">0.00</span></div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Profit</label>
                        <div class="h4 mb-3 font-weight-bold text-success">Tsh <span class="profit">0.00</span></div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Customer Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Customer Phone</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="customer_phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Payment Method</label>
                        <div class="d-flex justify-content-between">
                            <div class="radio-item">
                                <input type="radio" name="payment_method" id="cash" value="cash" checked>
                                <label for="cash"><i class="fa fa-money-bill text-success mr-1"></i>Cash</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="payment_method" id="bank" value="bank transfer">
                                <label for="bank"><i class="fa fa-university text-danger mr-1"></i>Bank</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="payment_method" id="card" value="Credit card">
                                <label for="card"><i class="fa fa-credit-card text-info mr-1"></i>Card</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Payment Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Tsh</span></div>
                            <input type="number" id="paid_amount" name="paid_amount" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Return Change</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Tsh</span></div>
                            <input type="number" id="balance" name="balance" class="form-control" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-save mr-2"></i>Save Order
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<style>
    .custom {
        background: #eceaea
    }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .card {
        border: none;
        margin-bottom: 1.5rem;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f8f9fa;
    }

    .radio-item input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .radio-item label {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        line-height: 25px;
    }

    .radio-item label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 2px;
        width: 20px;
        height: 20px;
        border: 2px solid #ddd;
        border-radius: 50%;
        background: #fff;
    }

    .radio-item input[type="radio"]:checked+label:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 7px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #28a745;
    }

    @media (max-width: 576px) {
        .card-header h5 {
            font-size: 1rem;
        }

        .form-group label,
        .input-group-text,
        .form-control {
            font-size: 0.9rem;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 0.6rem 1rem;
        }
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function () {
    $('.add_more').on('click', function (e) {
        e.preventDefault();

        var productOptions = $('.product_id').html();
        var numberofrow = $('.addMoreProduct tr').length + 1;

        var newRow = `
            <tr>
                <td class="text-center no">${numberofrow}</td>
                <td>
                    <select class="form-control product_id" name="product_id[]">
                        ${productOptions}
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control quantity text-center" value="1" min="1">
                </td>
                <td>
                    <input type="number" name="price[]" class="form-control price text-right" value="0.00" readonly> <!-- Selling Price -->
                </td>
                <td class="d-none">
                    <input type="number" name="cost_price[]" class="form-control cost_price text-right" value="0.00" readonly> <!-- Cost Price -->
                </td>
                <td>
                    <input type="number" name="discount[]" class="form-control discount text-center" value="0" min="0" max="100">
                </td>
                <td>
                    <input type="number" name="total_amount[]" class="form-control total_amount text-right" value="0.00" readonly>
                </td>
                <td class="d-none">
                    <input type="number" name="profit[]" class="form-control profit text-right" value="0.00" readonly> <!-- Profit -->
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm rounded-circle delete">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        $('.addMoreProduct').append(newRow);
        initializeRow($('.addMoreProduct tr:last'));
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        updateRowNumbers();
        calculateGrandTotal();
    });

    $(document).on('change', '.product_id', function () {
        var tr = $(this).closest('tr');
        var price = parseFloat($(this).find('option:selected').data('price')) || 0;
        var cost = parseFloat($(this).find('option:selected').data('cost')) || 0;

        tr.find('.price').val(price.toFixed(2));
        tr.find('.cost_price').val(cost.toFixed(2));

        tr.find('.quantity').val(1);
        tr.find('.discount').val(0);

        calculateRowTotal(tr);
    });

    $(document).on('input', '.quantity, .discount', function () {
        calculateRowTotal($(this).closest('tr'));
    });

    $('#paid_amount').on('input', function () {
        updateBalance();
    });

    function calculateRowTotal(tr) {
    var costPrice = parseFloat(tr.find('.cost_price').val()) || 0;
    var price = parseFloat(tr.find('.price').val()) || 0;
    var quantity = parseInt(tr.find('.quantity').val()) || 1;
    var discount = parseFloat(tr.find('.discount').val()) || 0;

    var subtotal = price * quantity;

    if (discount > subtotal) {
        discount = subtotal;
        tr.find('.discount').val(discount.toFixed(2));
    }

    var total = subtotal - discount;
    tr.find('.total_amount').val(total.toFixed(2));

    var profit = total - (costPrice * quantity);
    tr.find('.profit').val(profit.toFixed(2));

    calculateGrandTotal();
    }



    function calculateGrandTotal() {
        var grandTotal = 0;
        var totalProfit = 0;

        $('.total_amount').each(function () {
            var row = $(this).closest('tr');
            var profit = parseFloat(row.find('.profit').val()) || 0;

            grandTotal += parseFloat($(this).val()) || 0;
            totalProfit += profit;
        });

        $('.total').html(grandTotal.toFixed(2));
        $('.profit').html(totalProfit.toFixed(2));
        updateBalance();
    }

    function updateBalance() {
        var total = parseFloat($('.total').html()) || 0;
        var paid = parseFloat($('#paid_amount').val()) || 0;
        var balance = paid - total;
        $('#balance').val(balance.toFixed(2));
    }

    function updateRowNumbers() {
        $('.addMoreProduct tr').each(function (index) {
            $(this).find('.no').text(index + 1);
        });
    }

    function initializeRow(row) {
        row.find('.quantity').val(1);
        row.find('.cost_price').val('0.00');
        row.find('.price').val('0.00');
        row.find('.discount').val(0);
        row.find('.total_amount').val('0.00');
        row.find('.profit').val('0.00');
    }

    initializeRow($('.addMoreProduct tr:first'));
    });
</script>
@endsection
