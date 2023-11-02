<?php
include($_SERVER['DOCUMENT_ROOT'].'/config.php');
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
 
if (isset($_POST['otpVerify'])) {
  
    $mobile = $_POST['mobile'];
    $otp = $_POST['otp'];
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
        echo "nadim";
  }
}
?>
