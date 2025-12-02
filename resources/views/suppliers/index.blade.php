@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-truck mr-2"></i>Suppliers Management
                        </h5>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSup">
                            <i class="fa fa-plus mr-1"></i> Add New Supplier
                        </button>
                    </div>
                </div>
                        <div class="card-body">
                            @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Supplier name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$supplier->supplier_name}}</td>
                                        <td>{{$supplier->address}}</td>
                                        <td>{{$supplier->phone}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editSup{{ $supplier->id }}">
                                                <i class="fa fa-edit"></i>
                                                </button>
                                            <button type="button" class="btn btn-danger btn-sm ml-1" data-toggle="modal" data-target="#deleteSup{{ $supplier->id }}">
                                                <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editSup{{ $supplier->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-edit mr-2"></i>Edit Supplier
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                                <div class="form-group">
                                                        <label class="small text-muted">Supplier Name</label>
                                                        <input type="text" name="supplier_name" value="{{ $supplier->supplier_name }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                        <label class="small text-muted">Address</label>
                                                        <input type="text" name="address" value="{{ $supplier->address }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                        <label class="small text-muted">Phone</label>
                                                        <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                        <label class="small text-muted">Email</label>
                                                        <input type="email" name="email" value="{{ $supplier->email }}" class="form-control" required>
                                                </div>
                                                    <button type="submit" class="btn btn-info btn-block">
                                                        <i class="fas fa-save mr-2"></i>Update Supplier
                                                    </button>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteSup{{ $supplier->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-trash mr-2"></i>Delete Supplier
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                    <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                                    <h5>Are you sure you want to delete this supplier?</h5>
                                                    <p class="text-muted">{{ $supplier->supplier_name }}</p>
                                                    <div class="mt-4">
                                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                                            <h5 class="font-weight-light text-muted">No suppliers found</h5>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                            </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $suppliers->links('pagination::bootstrap-4') }}
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-search mr-2"></i>Search Suppliers
                    </h5>
                </div>
                        <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search suppliers...">
                </div>
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-secondary btn-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            </div>
        </div>
    </div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSup" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Supplier
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('suppliers.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label class="small text-muted">Supplier Name</label>
                        <input type="text" name="supplier_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="small text-muted">Address</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="small text-muted">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="small text-muted">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Save Supplier
                    </button>
                </form>
            </div>
          </div>
        </div>
    </div>

<style>
    /* Theme Colors */
    :root {
        --primary: #007bff;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
    }

    /* Table Styles */
    .table thead th {
        background-color: var(--light);
        border-bottom: 2px solid #e3e6f0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,.04);
    }

    /* Card Styles */
    .card {
        border: none;
        margin-bottom: 1.5rem;
    }

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    /* Button Colors */
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-info {
        background-color: var(--info);
        border-color: var(--info);
    }

    .btn-danger {
        background-color: var(--danger);
        border-color: var(--danger);
    }

    .btn-secondary {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }

    /* Text Colors */
    .text-primary {
        color: var(--primary) !important;
    }

    .text-muted {
        color: var(--secondary) !important;
    }

    /* Modal Styles */
    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .modal-header .close {
        color: #fff;
        text-shadow: none;
        opacity: .75;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    /* Form Styles */
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* Alert Styles */
    .alert-danger {
        background-color: #fff;
        border-left: 4px solid var(--danger);
        color: var(--danger);
        }
      </style>

@endsection