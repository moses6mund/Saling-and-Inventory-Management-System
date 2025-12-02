<!-- Add Product Modal -->
<div class="modal fade" id="addProduct" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Product
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="small text-muted">Product Name</label>
                        <input type="text" name="product_name" class="form-control" required>
                        @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Brand</label>
                        <input type="text" name="brand" class="form-control">
                        @error('brand')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Selling Price (Tsh)</label>
                        <input type="number" name="price" class="form-control" required>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Buying Price (Tsh)</label>
                        <input type="number" name="cost_price" class="form-control" required>
                        @error('cost_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                        @error('quantity')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Alert Stock Level</label>
                        <input type="number" name="alert_stock" class="form-control">
                        @error('alert_stock')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Save Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
