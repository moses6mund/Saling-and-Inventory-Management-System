@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-box mr-2"></i>Products Management
                        </h5>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProduct">
                            <i class="fa fa-plus mr-1"></i> Add New Product
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @error('product_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="userTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Brand</th>
                                    <th>Selling Price (Tsh)</th>
                                    <th>Buying Price (Tsh)</th>
                                    <th>Quantity</th>
                                    <th>Stock Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <p id="noResult" style="display:none;">No result found</p>

                                @forelse ($products as $key => $product)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-capsules text-primary mr-2"></i>
                                            <span class="font-weight-medium">{{ $product->product_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td class="text-right">Tsh {{ number_format($product->price, 2) }}</td>
                                    <td class="text-right">Tsh {{ number_format($product->cost_price, 2) }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                    <td class="text-center">
                                        @if ($product->alert_stock >= $product->quantity)
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Low Stock ({{ $product->quantity }})
                                            </span>
                                        @elseif ($product->quantity <= 100)
                                            <span class="badge badge-warning badge-pill">
                                                <i class="fas fa-exclamation-circle mr-1"></i>Medium Stock ({{ $product->quantity }})
                                            </span>
                                        @else
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-check-circle mr-1"></i>In Stock ({{ $product->quantity }})
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editProduct{{ $product->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteProduct{{ $product->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Include Edit Modal -->
                                @include('products.partials.edit')

                                <!-- Include Delete Modal -->
                                @include('products.partials.delete')
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-box-open fa-3x text-muted mb-2"></i>
                                        <p class="text-muted text-red">No products found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-search mr-2"></i>Search Products
                    </h5>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                    </div>
                </div>
            </div>
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
</div>

<!-- Include Add Product Modal -->
@include('products.partials.create')

<!-- Optional Custom Styles -->
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

    .modal-header .close {
        padding: 1rem;
        margin: -1rem -1rem -1rem auto;
    }
</style>
@endsection

@section('script')
<script>
    // $(document).ready(function() {
    //     $('#searchInput').on('keyup', function() {
    //         var value = $(this).val().toLowerCase();
    //         $('#userTable tbody tr').filter(function() {
    //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //         });
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#userTable tbody tr');
        const noResult = document.getElementById('noResult');

        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            let visibleCount = 0;

            rows.forEach(function(row) {
            const rowText = row.textContent.toLowerCase();
            const match = rowText.includes(value);
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
            });

            // Show or hide "No result found" message
            if (visibleCount === 0) {
            noResult.style.display = 'block';
            } else {
            noResult.style.display = 'none';
            }
        });
        });


</script>
@endsection
