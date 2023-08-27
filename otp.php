<?php
include_once('config.php');
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