<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProduct{{ $product->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash mr-2"></i>Delete Product
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                    <h5>Are you sure you want to delete this product?</h5>
                    <p class="text-muted mb-4">{{ $product->product_name }}</p>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
