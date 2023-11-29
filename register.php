<?php

session_start(); // Start the session
include('config.php');

if ( isset($_POST['registerUser']) || isset($_POST['registerServicer'])) {
    $mobile = $_POST['mobile']; // Sanitize input
    $query = "SELECT id FROM users WHERE mobile = $mobile";
    $userCheck = mysqli_query($connection, $query);
    if (mysqli_num_rows($userCheck) > 0) {

        $message = "This mobile is already exists";
        // Redirect to the index.php page with the message
        header("Location: register.php?message=" . urlencode($message));
        exit;

    } else {

        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $password = md5($_POST['password']);
        $category_id = $_POST['category_id'];
        $role = $_POST['role'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $address = $_POST['address'];
        $fullAddress = "$city, $area, $address";

        $otp = mt_rand(100000, 999999); // Generates a random six-digit OTP
        if($_POST['password'] !== $_POST['confirm_password'])
        {
            $message = "Passwords do not match";
        
           header("Location: register.php?message=" . urlencode($message) . "&role=" . urlencode($role));
           
           exit; 
        }

        $queryUser = "INSERT INTO `users`(`name`, `email`,`password`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','','$password','$mobile','$otp','$role','Unverify')";
        $userRegister = mysqli_query($connection, $queryUser);

        $query = "SELECT id FROM users WHERE mobile = '$mobile'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        if ($role == "servicer") {

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `address`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','8','$category_id','$fullAddress','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            if ($resultProfile) {
                header("Location: register.php?id=" . urlencode($id));
                exit;
            } else {
                $message = "Something is wrong";
        
                header("Location: register.php?message=" . urlencode($message));
                exit; 
            }
        } else {
            $queryUserProfile = "INSERT INTO `user_profiles`(`user_id`, `address`, `profile_image`) VALUES ('$id','$fullAddress','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            if ($resultProfile) {
                header("Location: register.php?id=" . urlencode($id));
                exit;
            } else {
                $message = "Something is wrong";
        
                header("Location: register.php?message=" . urlencode($message));
                exit; 
            }
        }
    }

 
}
 


 

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - <?php echo $_GET['role'] ?></title>


    <link rel="icon" href="" type="image/x-icon">
    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="frontend/includes/css/footer.css">
    <link rel="stylesheet" href="frontend/includes/css/otp.css">
    <link rel="stylesheet" href="frontend/includes/css/register.css">

</head>

<body style=" background: #fc4a1a;
background: -webkit-linear-gradient(to right, #f7b733, #fc4a1a);
background: linear-gradient(to right, #f7b733, #90a9ce)">
  

  <!-- header -->
  <?php include_once("header.php"); ?>
  <!-- end header -->
  <!-- alert message -->
  <?php include_once "frontend/includes/layouts/message/alert.php" ?>
  <!-- end alert message -->

    <!------ Include the above in your HEAD tag ---------->

    <div class="container register rounded-5" style="margin-top: 200px;margin-bottom: 100px;">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="frontend/image/The-search.png" alt="" style="width:200px" />
                <h3>Welcome</h3>
                <h4>Find Services On-the-Go</h4>
                <p>Connect with Providers at Your Own Pace.</p>
                <input type="submit" name="" value="Login" /><br />
            </div>
            <div class="col-md-9 register-right">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['role'] === 'User') ? 'active' : ''; ?>" id="home-tab" data-toggle="tab" href="register.php?role=User" role="tab" aria-controls="home" aria-selected="true">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_GET['role'] != 'User') ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="register.php?role=Servicer" role="tab" aria-controls="profile" aria-selected="true">Servicer</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- user -->
                    <div class="tab-pane fade show <?php echo ($_GET['role'] === 'User') ? 'active' : ''; ?>" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Apply as a <?php echo $_GET['role'] ?></h3>
                        
                        <?php include_once('frontend/includes/layouts/register/user_form.php') ?>

                    </div>
                    <!-- end user -->
                    <!-- servicer -->
                    <div class="tab-pane fade show <?php echo ($_GET['role'] != 'User') ? 'active' : ''; ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="register-heading">Apply as a <?php echo $_GET['role'] ?></h3>

                        <?php include_once('frontend/includes/layouts/register/servicer_form.php') ?>
                    </div>
                    <!-- end servicer -->
                    <!-- otp -->
                    <div class="tab-pane fade show <?php echo (isset($_GET['id'])) ? 'active' : ''; ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="register-heading">Enter otp</h3>

                        <?php include_once('frontend/includes/layouts/register/otp.php') ?>
                    </div>
                    <!-- end otp -->
                </div>
            </div>
        </div>

    </div>

    <!-- footer -->
    <?php include_once("footer.php");?>
    <!-- end footer -->
   
    

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>