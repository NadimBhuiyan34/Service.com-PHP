<?php
 include_once('config.php');
 if (isset($_POST['loginRequest'])) {
  $mobile = $_POST['mobile'];
  
  // Check if user exists
  $query = "SELECT * FROM users WHERE mobile = '$mobile'";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {
      
      
      // Generate OTP
      $otp = mt_rand(1000, 9999);
      
      // Update OTP in the database
      $updateQuery = "UPDATE users SET otp = '$otp' WHERE mobile = '$mobile'";
      if ($connection->query($updateQuery)) {
          $res = [
              'status' => 'success',
              'mobile' => $mobile,
              
          ];
          
      }  
  } 
  else {
      $res = [
          'status' => 'fail',
          'message' => 'User with the provided mobile number does not exist'
      ];
  }
 
  header('Content-Type: application/json');
  echo json_encode($res);
}


