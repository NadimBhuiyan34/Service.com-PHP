<?php
include_once('config.php');
// category service
if (isset($_POST['categoryService'])) {
    $id  = $_POST['id'];
    $query = "SELECT * FROM services WHERE category_id = $id ORDER BY id DESC";
    $data = mysqli_query($connection, $query);

    if ($data) {
        $services = array();
        while ($service = mysqli_fetch_assoc($data)) {
            $services[] = $service;
        }

        $res = [
            'status' => 'success',
            'services' => $services

        ];
    } else {
        $res = [
            'status' => 'fail',

        ];
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}


// register
if (isset($_POST['registerRequest'])) {
    $mobile = $_POST['mobile']; // Sanitize input
    $query = "SELECT id FROM users WHERE mobile = $mobile";
    $userCheck = mysqli_query($connection, $query);

    if (mysqli_num_rows($userCheck) > 0) {

        $res = [
            'status' => 'fail',
            'message' => 'User with the provided mobile number does not exist'
        ];
    } else {


        // Sanitize and get form data
        $name = $_POST['name'];
        $role = $_POST['role'];
        // $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $category_id = $_POST['category'];
        $location = $_POST['location'];
        $services = array_filter($_POST["services"]);
        $service_id = json_encode($services);

        // otp generate
        $otp = mt_rand(1000, 9999);
        //   query insert
        $queryUser = "INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','','$mobile','$otp','$role','Active')";
        $resultUser = mysqli_query($connection, $queryUser);

        if ($resultUser) {
            $query = "SELECT id FROM users WHERE mobile = $mobile";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
              if($role == 'servicer')
              {
                $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','2','$category_id','$location','','','','')";
                $resultProfile = mysqli_query($connection, $queryUserProfile);
              }
              else
              {
                $queryUserProfile = "INSERT INTO `user_profiles`(`user_id`,`address`,`profile_image`) VALUES ('$id','$location','')";
                $resultProfile = mysqli_query($connection, $queryUserProfile);
              }
           
            if ($resultProfile) {
                $response = [
                    'status' => 'success',
                    'mobile' => $_POST['mobile'],
                ];
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// otp
if(isset($_POST['otpVerify']))
{
    $mobile = $_POST['mobileRegister'];
    $otp = $_POST['otpRegister'];
    $submittedOTP = implode('', $otp);
  // Check if user exists
   
  $query = "SELECT * FROM users WHERE mobile = '$mobile' AND otp = '$submittedOTP'";
  $result = $connection->query($query);
  
  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      session_start();
       
      $_SESSION['user_id'] = $user['id'];
       
      header('Location:index.php');
  
      exit;
        
  } 
  else {
        echo "Otp is wrong";
        
  }
}
