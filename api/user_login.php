<?php
require '../config.php';
if ($_POST['verify'] == "login") {

  $mobile = $_POST['mobile'];
  $password = md5($_POST['password']);
  // Check if user exists
  $query = "SELECT * FROM users WHERE mobile = '$mobile'";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {
      
      


    $user = $result->fetch_assoc();
    
    // Compare the hashed password in the database with the entered password
    if ($user['password'] === $password) {

        $id = $user['id'];
        $name = $user['name'];
        $data = [
            'id' => $id,
            'name' => $name,
        ];
         
    } else {

          $data = [
          'status' => 'fail',
          'message' => 'Yor password is wrong'
      ];
    }
      // Generate OTP
   
    //   $otp = mt_rand(100000, 999999);
      
      // Update OTP in the database
    //   $updateQuery = "UPDATE users SET otp = '$otp' WHERE mobile = '$mobile'";
    //   if ($connection->query($updateQuery)) {
    //       $data = [
    //           'status' => 'success',
    //           'mobile' => $mobile,
              
    //       ];
          
    //   }  
  } 
  else {
      $data = [
          'status' => 'fail',
          'message' => 'User with the provided mobile number does not exist'
      ];
  }
 
  header('Content-Type: application/json');
  echo json_encode($res);
}
 
// otp verify for login
if ($_POST['verify'] == "otp") {

    $mobile = $_POST['otpMobile'];
    $submittedOTP = $_POST['otp'];


    $query = "SELECT * FROM users WHERE mobile = '$mobile' AND otp = '$submittedOTP'";
    $result =  $resultProfile = mysqli_query($connection, $query);


    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $id = $user['id'];
        $name = $user['name'];
        $data = [
            'id' => $id,
            'name' => $name,
        ];

    
    } else {
        $data = [
            'message' => "otp is wrong",
        ];
    }


    header('Content-Type: application/json');
    echo json_encode($data);
}

?>