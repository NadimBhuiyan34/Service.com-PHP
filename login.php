<?php
include('config.php');
if (isset($_POST['loginBtn'])) {

  $mobile = $_POST['mobile'];
 
  $lastThreeDigits = substr($mobile, -3);
  $password = md5($_POST['password']);
  // Check if user exists
  $query = "SELECT * FROM users WHERE mobile = '$mobile'";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {

      $user = $result->fetch_assoc();
      $id=$user['id'];
      // Compare the hashed password in the database with the entered password
      if ($user['password'] === $password) {
          if ($user['password'] === $password && $user['status'] == 'Active') {
              
            session_start(); // Start the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");   
               
               
          } else if ($user['password'] === $password && $user['status'] == 'Inactive') {

            
              $message = "Your account is inactive please contact with admin";
              header("Location: login.php?error=" . urlencode($message));            
              exit; 

          }else if($user['password'] === $password && $user['status'] == 'Pending')
          {

            $message = "Your account is pending please contact with admin";
            header("Location: login.php?error=" . urlencode($message));            
            exit;
              
          }
          
          else {
              
              // Generate OTP
              $otp = mt_rand(100000, 999999);

             
              $updateQuery = "UPDATE users SET otp = '$otp' WHERE mobile = '$mobile'";
              if ($connection->query($updateQuery)) {  
                header("Location: login.php?id=" . urlencode($id). "&otp=" . urlencode('unverify'). "&mobile=" . urlencode($lastThreeDigits));             
                         
                exit;
              }
          }
      } else {

           $message = "Your password is incorrect";
            header("Location: login.php?error=" . urlencode($message));            
            exit;
          
      }
  } else {

            $message = "Mobile number does not exist";
            header("Location: login.php?error=" . urlencode($message));            
            exit;
      
  }

  
}
// otp
// otp
if (isset($_POST['otpVerify'])) {

  $id = $_POST['id'];
  $submittedOTP = $_POST['first'] . $_POST['second'] . $_POST['third'] . $_POST['fourth'] . $_POST['fifth'] . $_POST['sixth'];
   
  $query = "SELECT * FROM users WHERE id = '$id' AND otp = '$submittedOTP'";
  $result = mysqli_query($connection, $query);

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Set session variables
      session_start(); // Start the session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['role'] = $user['role'];
      $role = $user['role'];
      $status = ($role == 'servicer') ? 'Pending' : 'Active';
      $updateQuery = "UPDATE `users` SET `status`='$status' WHERE id = $id";
       
      if(mysqli_query($connection, $updateQuery))
      {
          header("Location: index.php");
          exit;
      }
      // Redirect or perform further actions as needed
     
  } else {
      $message = "OTP is wrong";
      header("Location: login.php?id=" . urlencode($id). "&otp=" . urlencode('unverify'). "&mobile=" . urlencode($lastThreeDigits) . "&error=" . urlencode($message));
      exit;
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
  <title>Login</title>


  <link rel="icon" href="" type="image/x-icon">
  <!-- Google Fonts -->

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <link rel="stylesheet" href="frontend/includes/css/footer.css">
  <link rel="stylesheet" href="frontend/includes/css/login.css">


</head>

<body style=" background: #fc9e1a;
background: -webkit-linear-gradient(to right, #f7b733, #fc4a1a);
background: linear-gradient(to right, #f7e333, rgb(148, 156, 179))">
  
  <!-- header -->
  <?php include_once("header.php");?>
  <!-- end header -->
   <!-- alert message -->
   <?php include_once "frontend/includes/layouts/message/alert.php" ?>
  <!-- end alert message -->
  <!-- login section -->
  <section class=" gradient-form rounded-4" style="margin-top: 150px;">
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <img src="frontend/image/The-search.png" style="width: 185px;" alt="logo">

                  </div>

                  <form action="login.php" method="POST" class="<?php echo (isset($_GET['otp'])) ? 'd-none' : ''; ?>">
                    <p class="text-center fw-bold">Please login to your account</p>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="mobile">Mobile Number</label>
                      <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Phone number" required />

                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" id="password" name="password" class="form-control" required />

                    </div>

                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 p-3" type="submit" name="loginBtn">Login</button><br>
                      <a class="text-muted" href="#!">Forgot password?</a>
                    </div>

                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Don't have an account?</p>
                     
                      <a href="register.php?role=user" class="btn btn-outline-danger">Create new</a>
                    </div>

                  </form>
                  <div class="<?php echo (isset($_GET['otp'])) ? '' : 'd-none'; ?>">
                  <?php include_once('frontend/includes/layouts/register/otp.php') ?>
                  </div>
                 
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <img src="https://www.sme-news.co.uk/wp-content/uploads/2021/11/Login.jpg" alt="" class="img-fluid" style="">
                  <h4 class="mb-4"></h4>
                  <p class="small mb-0"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end login -->
 <!-- footer -->
  <?php include_once("footer.php");?>
  <!-- end footer -->

  <!-- js -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script>
        // Function to hide the alert and progress bar after a delay
        function hideAlertAndProgressBar() {
            const duration = 5000; // 5000ms = 5 seconds
            const progressBar = $(".progress-bar");

            let progress = 0;
            const interval = 100; // 100ms interval for updating progress
            const steps = duration / interval;

            const updateProgressBar = setInterval(function() {
                progress += 100 / steps;
                progressBar.css("width", progress + "%");

                if (progress >= 100) {
                    clearInterval(updateProgressBar);
                    $(".fixed-alert").fadeOut(500, function() {
                        $(this).remove(); // Remove the entire .fixed-alert container
                    });
                }
            }, interval);
        }

        // Call the function when the page loads
        hideAlertAndProgressBar();
    </script>
  <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
  <!-- Vendor JS Files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>