 <!-- Modal -->
 <div class="modal fade" id="addAdvertise" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog ">
         <div class="modal-content">
             <div class="modal-header  bg-primary">
                 <h5 class="modal-title fw-bold text-white" id="exampleModalLabel">Add New Advertisements</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                <form action="advertise.php" method="POST" enctype="multipart/form-data">
                 <div class="mb-3">
                     <label for="title" class="form-label text-black fw-bold">Title</label>
                     <input type="text" class="form-control" id="title" name="title" placeholder="">
                 </div>
                 <div class="mb-3">
                     <label for="image" class="form-label text-black fw-bold">Image</label>
                     <input type="file" class="form-control" name="image" id="image" required>
                 </div>
                 <div class="mb-3">
                     <label for="link" class="form-label text-black fw-bold">Site Link</label>
                     <input type="link" class="form-control" name="link" id="link" placeholder="">
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="addAdvertise">Save changes</button>
             </div>
             </form>
         </div>
     </div>
 </div>