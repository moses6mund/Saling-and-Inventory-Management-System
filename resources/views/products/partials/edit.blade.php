<!-- Edit Product Modal -->
<div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Edit Product
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="small text-muted">Product Name</label>
                        <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Brand</label>
                        <input type="text" name="brand" value="{{ $product->brand }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Selling Price (Tsh)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Buying Price (Tsh)</label>
                        <input type="number" name="cost_price" value="{{ $product->cost_price }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Quantity</label>
                        <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="small text-muted">Alert Stock Level</label>
                        <input type="number" name="alert_stock" value="{{ $product->alert_stock }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-info btn-block">
                        <i class="fas fa-save mr-2"></i>Update Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
