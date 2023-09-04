<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Service Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="alertMessageRegister" class="alert d-none" role="alert"></div>

                <div id="alertMessage" class="alert d-none" role="alert"></div>

                <form id="registerForm" enctype="multipart/form-data" method="POST">
                    
                    <div class="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile*</label>
                            <input type="text" class="form-control" id="mobileRegister" name="mobile" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Select your role*</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select a Role</option>
                                <option value="servicer">Servicer</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>



                    <div class="mb-3 d-none" id="categoryDiv">
                        <label for="category" class="form-label">Select Work Category*</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select a category</option>
                            <?php
                            $query = "SELECT * FROM categories ORDER BY id DESC";

                            // $query = "SELECT * FROM categories ORDER BY id DESC";
                            $categories = mysqli_query($connection, $query);
                            while ($category = mysqli_fetch_assoc($categories)) {
                            ?>
                                <option value="<?php echo $category['id'] ?>">

                                    <?php echo $category['title'] ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>
                    <div id="serviceContainer" class="d-none row mb-3 p-3" style="background-color: rgb(3, 2, 2);">

                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location*</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="number" class="form-control" id="experience" name="experience" required>
                    </div> -->
                    <!-- <div class="mb-3">
                        <label for="biography" class="form-label">Biography</label>
                        <textarea class="form-control" id="biography" name="biography" rows="3" required></textarea>
                    </div> -->

                    <!-- <div class="mb-3">
                        <label for="workImage" class="form-label">Work Image</label>
                        <input type="file" class="form-control" id="workImage" name="workImage[]" accept="image/*" multiple required>
                    </div> -->



                    



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary registerBtn" form="serviceForm" name="registerRequest">Submit</button>
            </div>
            </form>
            <form action="register.php" method="POST" id="otpRegisterForm" class="d-none">

                <input type="hidden" name="mobileRegister" value="" id="otpRegisterMobile">

                <div class="mb-3 text-center">
                    <h2>Enter OTP</h2>
                    <p>We've sent an OTP to your mobile number. Please enter it below.</p>
                </div>

                <div class="mb-3 d-flex justify-content-center gap-2 w-50 mx-auto">
                    <input type="text" class="form-control otp-box shadow fs-4 text-center" maxlength="1" inputmode="numeric" name="otpRegister[]" />
                    <input type="text" class="form-control otp-box shadow fs-4 text-center" maxlength="1" inputmode="numeric" name="otpRegister[]" />
                    <input type="text" class="form-control otp-box shadow fs-4 text-center" maxlength="1" inputmode="numeric" name="otpRegister[]" />
                    <input type="text" class="form-control otp-box shadow fs-4 text-center" maxlength="1" inputmode="numeric" name="otpRegister[]" />
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="otpVerify" id="otpRegister">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('change', '#role', function() {
            var selectedroleName = $(this).val();
            if (selectedroleName == "servicer") {
                $('#categoryDiv').removeClass('d-none');
                // $('#serviceContainer').removeClass('d-none');      
            } else {
                $('#categoryDiv').addClass('d-none');
                $('#serviceContainer').addClass('d-none');
            }
        });
        // Listen for changes on the select element
        $(document).on('change', '#category', function() {
            var selectedCategoryId = $(this).val();
            var categoryService = "categoryService";
            if (selectedCategoryId !== "") {
                fetchServices(selectedCategoryId, categoryService); // Call the fetchServices function
            } else {
                $('#servicesContainer').empty(); // Clear services
            }
        });

        function fetchServices(categoryId, categoryService) {
            // Perform an AJAX request to fetch services for the selected category
            $.ajax({
                url: 'register.php',
                method: 'post',
                dataType: 'text',
                data: {
                    id: categoryId,
                    categoryService: categoryService
                }, // Send selected category ID as a parameter
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status == 'success') {
                        var serviceContainer = $('#serviceContainer');
                        serviceContainer.empty();
                        $.each(res.services, function(index, service) {
                            var checkbox = $('<div class="form-check form-switch col-6" id="serviceDiv">').append(
                                $('<input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" value="' + service.id + '" name="services[]">'),
                                $('<label class="form-check-label text-white" for="flexSwitchCheckDefault">').text(service.title)
                            );
                            serviceContainer.append(checkbox);
                        });
                        $('#serviceContainer').prepend('<label for="location" class="form-label text-white">Select Your Service Item</label>');
                        serviceContainer.removeClass('d-none');
                    }


                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.statusText);
                }
            });
        }
    });
</script>