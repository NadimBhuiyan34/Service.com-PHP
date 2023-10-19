<!-- Add new modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark  text-center">
                <h3 class="modal-title text-white text-center mx-auto" id="exampleModalLabel">Add New Category 
</h3>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body bg-dark-light">
                <form id="offerForm" action="category.php" enctype="multipart/form-data" method="POST">
                    <div class="card p-2 rounded-4">
                    <div class="row">
                    <div class="mb-3 col-6">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="type" class="form-label fw-bold">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="included" class="form-label fw-bold">Included Items</label>
                        <textarea class="form-control" id="included" name="included" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="excluded" class="form-label fw-bold">Excluded Items</label>
                        <textarea class="form-control" id="excluded" name="excluded" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label fw-bold">Banner Image</label>
                        <input type="file" class="form-control" id="bannerImage" name="bannerImage" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer mx-auto">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" name="addCategory">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end add new modal -->