<!-- start header -->

<header class="fw-bold background-container" style="position: fixed; top: 30px; width: 100%; z-index: 1000;">
    <nav class="navbar navbar-expand-lg mx-auto round" style="width: 80%; background-color:hwb(227 18% 16% / 0.981)">
        <div class="container rounded-2" style="background-color:white">

          <div class="" style="background-color:white;">
            <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" class="px-2" alt="" style="width:150px;height:90px">
          </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto mx-auto ">
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="index.php"> <i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="index.php"> <i class="fa-solid fa-user-nurse"></i> Servicer</a>
                    </li>

                
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs service-icon"></i> Service Category
                        </a>
                        <ul class="dropdown-menu  shadow border-2" style="width: 300px;background-color:white">
                        <?php 
                     $query = "SELECT * FROM categories WHERE status = 'Active' ORDER BY id DESC";
                     $categories = mysqli_query($connection, $query);
                     while ($category = mysqli_fetch_assoc($categories)) {
                        ?>
                            <li class="nav-item px-3">
                                <a class="nav-link" href="construction.php"><?php echo $category['title'] ?></a>
                            </li>
                        <?php } ?>    
                        </ul>



                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="contactus.php"> <i class="fas fa-envelope contact-icon"></i> Contact Us</a>
                    </li>
                    
                    
                    


                   




                </ul>
                <div class="row">
                   <ul class="navbar-nav ml-auto mx-auto">
                    <li class="nav-item dropdown px-3 d-none">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="https://img.freepik.com/premium-vector/man-avatar-profile-picture-vector-illustration_268834-538.jpg" class="" alt="" style="width:50px;height:50px;">
                          Nadim Bhuiyan
                        </a>
                        <ul class="dropdown-menu  shadow" style="width: 300px">
                            <!-- <li class="nav-item px-3">
                                <a class="nav-link" href="gellery.php">Gellery</a>
                            </li> -->
                            <li class="nav-item px-3">
                                <a class="nav-link" href="handover.php">Hand Over Project</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link" href="Inauguration.php">Logout</a>
                            </li>
                        </ul>



                    </li>
                    <li class="nav-item dropdown px-3 d-none d-md-block d-lg-block">
                        <a class="btn btn-sm btn-success shadow dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-plus"></i> Register
                        </a>
                        <ul class="dropdown-menu  shadow border-2" style="width: 180px;background-color:rgb(202, 228, 255)">
                            <li class="nav-item px-3">
                                <a class="nav-link" href="register.php?role=User"><i class="fa-solid fa-user"></i> User</a>
                            </li>
                            <li class="nav-item px-3">
                            <a class="nav-link" href="register.php?role=Servicer"><i class="fa-solid fa-user-nurse"></i> Servicer</a>

                            </li>
                        </ul>
                    </li>
                    <li class="nav-item px-3 d-none d-md-block d-lg-block">
                        <a class=" btn btn-sm btn-danger shadow" href="login.php"> <i class="fa-solid fa-right-to-bracket"></i> Login</a>
                    </li>
                   </ul>
                   
                    
                </div>
            </div>
        </div>
          
    </nav>
</header>
<!-- end header -->