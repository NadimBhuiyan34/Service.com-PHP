<!-- Add new modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="offerForm" action="service.php"  method="POST">
                <div class="mb-3">
                        <label for="category" class="form-label">Status</label>
                        <select class="form-select" id="category" name="categoryId" required>
                        <option value="">Select Category</option>
                    <?php 
                     $query = "SELECT * FROM categories ORDER BY id DESC";
                     $categories = mysqli_query($connection, $query);
                     while ($category = mysqli_fetch_assoc($categories)) {
                        ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                    <?php
                     }
                    ?>         
                           
                        </select>
                    </div>

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
                        <label for="charge" class="form-label">Charge</label>
                        <input type="number" class="form-control" id="charge" name="charge" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addService">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end add new modal -->