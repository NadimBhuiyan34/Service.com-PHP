<form action="register.php" method="POST" enctype="multipart/form-data">
                            <div class="row register-form">
                            <input type="hidden" name="role" value="servicer">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name*</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="form-label">Mobile*</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password*</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="form-label">Confirm Password*</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile" name="profile" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">Work Category*</label>
                                        <select class="form-select" aria-label="Default select example" name="category_id" id="category_id" required>
                                          
                                            <?php
                                            $query = "SELECT id, title FROM categories WHERE status = 'Active' ORDER BY id DESC;
                                                    ";
                                            $categories = mysqli_query($connection, $query);
                                            while ($category = mysqli_fetch_assoc($categories)) {
                                            ?>
                                                <option value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="form-label">City*</label>
                                        <select class="form-select" aria-label="Default select example" name="city" id="city" required>
                                            
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Chittagong">Chittagong</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="area" class="form-label">Area*</label>
                                        <select class="form-select" aria-label="Default select example" name="area" id="area" required>
                                           

                                            <option value="Tejgaon">Tejgaon</option>
                                            <option value="Dhanmondi">Dhanmondi</option>
                                            <option value="Banani">Banani</option>
                                            <option value="Gulshan">Gulshan</option>
                                            <option value="Baridhara">Baridhara</option>
                                            <option value="Khilgaon">Khilgaon</option>
                                            <option value="Mirpur">Mirpur</option>
                                            <option value="Uttara">Uttara</option>
                                            <option value="Uttara">Banasree</option>
                                            <option value="Uttara">Aftabnagar</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience" class="form-label">Work Experience</label>
                                        <input type="number" class="form-control" id="experience" name="experience" required>
                                    </div>
                                 
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="profile" class="form-label">Biography</label>
                                        <textarea id="profile" name="profile" class="form-control" rows="4" placeholder="Enter your biography here..."></textarea>
                                    </div>
                                  
                                </div>
                                <div class="col-md-6">
                                <input type="submit" class="btnRegister"  value="Registration" name="registerServicer" />
                                </div>
                               
                            </div>
                        </form>