  
  <!-- Add new modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header bg-info">
                  <h5 class="modal-title text-white" id="exampleModalLabel">Add New Category</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <form id="offerForm" enctype="multipart/form-data" >
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="included" class="form-label">Included Items</label>
            <textarea class="form-control" id="included" name="included" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="excluded" class="form-label">Excluded Items</label>
            <textarea class="form-control" id="excluded" name="excluded" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="bannerImage" class="form-label">Banner Image</label>
            <input type="file" class="form-control" id="bannerImage" name="bannerImage" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="">Select status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="addNew">Save</button>
              </div>
              </form>
          </div>
      </div>
  </div>
  <!-- end add new modal -->