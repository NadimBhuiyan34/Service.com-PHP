<!-- start header -->
<?php
require 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

 
 
?>
<header class="fw-bold background-container" style="position: fixed; top: 30px; width: 100%; z-index: 1000;">
    <nav class="navbar navbar-expand-lg mx-auto rounded-5" style="width: 80%; background-color:hwb(0 0% 100% / 0.981)">
        <div class="container rounded-4" style="background-color:rgb(255, 176, 40)">

          <div class="" style="background-color:white;">
            <img src="frontend/image/The-search.png" class="px-2" alt="" style="width:150px;height:80px">
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
                        <a class="nav-link text-dark" href="servicer.php?type=All"> <i class="fa-solid fa-users-gear"></i> Servicer</a>
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
                                <a class="nav-link" href="servicer.php?type=<?php echo $category['id'] ?>"><?php echo $category['title'] ?></a>
                            </li>
                        <?php } ?>    
                        </ul>

                    </li>

                    <?php
                     if(isset($_SESSION['user_id']))
                    {
                        $role = $_SESSION['role'];

                        if($role == 'servicer' || $role == 'user')
                        {
                    ?>    
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs service-icon"></i> Service Request
                        </a>
                        <ul class="dropdown-menu  shadow border-2" style="width: 200px;background-color:white">
                        <li class="nav-item px-3">
                                <a class="nav-link" href="request.php?status=pending">Pending</a>
                            </li>
                        <li class="nav-item px-3">
                                <a class="nav-link" href="request.php?status=accepted">Ongoing</a>
                            </li>
                        <li class="nav-item px-3">
                                <a class="nav-link" href="request.php?status=completed">Completed</a>
                            </li>
                        </ul>

                    </li>
                    <?php } }?>

                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="contactus.php"> <i class="fas fa-envelope contact-icon"></i> Contact Us</a>
                    </li>                   

                </ul>
                <div class="row">
                   <ul class="navbar-nav ml-auto mx-auto">
                   <li class="nav-item dropdown px-3 <?php echo isset($_SESSION['user_id']) ? 'd-block' : 'd-none'; ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if(isset($_SESSION['user_id']))
                            {
                                $id = $_SESSION['user_id'];
                                $role = $_SESSION['role'];

                              if($role == 'user' || $role == 'admin')
                              {
                                $userQuery = "SELECT users.name, user_profiles.profile_image FROM users
                                LEFT JOIN user_profiles ON users.id = user_profiles.user_id
                                WHERE users.id = '$id'";
                                                                                   
                              }
                              else
                              {
                                $userQuery = "SELECT users.name, servicer_profiles.profile_image 
                                FROM users
                                LEFT JOIN servicer_profiles ON users.id = servicer_profiles.user_id
                                WHERE users.id = '$id'";

                              }
                              $result = $connection->query($userQuery);
                              $userData = $result->fetch_assoc();
                              $name = $userData['name'];
                              $profile_image = $userData['profile_image'];

                            }
                             
                            ?>
                        <img src="frontend/image/profile/<?php echo $profile_image ?>" class="" alt="" style="width:50px;height:50px; border-radius: 50%;">

                          <?php echo $name ?>
                        </a>
                        <ul class="dropdown-menu  shadow " style="width: 250px">
                            <li class="nav-item px-3">
                                <?php echo ucfirst($_SESSION['role'])  ?>
                            </li>
                            <hr>
                            <li class="nav-item px-3">
                                <a class="nav-link" href="profile.php">   <i class="fas fa-user profile-icon"></i> Profile</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link" href="profile.php">   <i class="fas fa-user profile-icon"></i> Request List</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link text-danger" href="logout.php">  <i class="fas fa-sign-out-alt logout-icon"></i>  Logout</a>
                            </li>
                        </ul>



                    </li>

                    <div class="d-flex <?php echo isset($_SESSION['user_id']) ? 'd-none' : 'd-block'; ?>">
                    <li class="nav-item dropdown px-3 d-none d-md-block d-lg-block">
                        <a class="btn btn-sm btn-success shadow dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-plus"></i> Register
                        </a>
                        <ul class="dropdown-menu  shadow border-2" style="width: 180px;background-color:rgb(202, 228, 255)">
                            <li class="nav-item px-3">
                                <a class="nav-link" href="register.php?role=user"><i class="fa-solid fa-user"></i> User</a>
                            </li>
                            <li class="nav-item px-3">
                            <a class="nav-link" href="register.php?role=servicer"><i class="fa-solid fa-user-nurse"></i> Servicer</a>

                            </li>
                        </ul>
                    </li>
                    <li class="nav-item px-3 d-none d-md-block d-lg-block">
                        <a class=" btn btn-sm btn-danger shadow" href="login.php"> <i class="fa-solid fa-right-to-bracket"></i> Login</a>
                    </li>
                    </div>
                  
                   </ul>
                   
                    
                </div>
            </div>
        </div>
          
    </nav>
</header>
<!-- end header -->