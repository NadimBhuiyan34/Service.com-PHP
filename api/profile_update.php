<?php
require '../config.php';
if($_POST['verify'] == "profileUpdate")
{

     if (isset($_FILES["profile"]) && $_FILES["profile"]["error"] == 0) {

          $uploadDir = "https://otp799999.000webhostapp.com/admin/public/profile/"; // Directory to store uploaded images
          $targetFile = $uploadDir . basename($_FILES["profile"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
          
          $check = getimagesize($_FILES["profile"]["tmp_name"]);
          
         if ($check !== false) {
          if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {

              $imageName = $_FILES["profile"]["name"];
                      
           }  
     
         }  
          
         
      } 

    $id=$_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $profileImage = $imageName ?? '';
    $query = "SELECT role FROM users WHERE id = '$id'";
    $result =  $resultProfile = mysqli_query($connection, $query);
 
 
  if ($result->num_rows > 0) {
      
      $user = $result->fetch_assoc();

      $updateQuery = "UPDATE `users` SET `name`='$name'' WHERE id = $id";
      $resultUser = mysqli_query($connection, $updateQuery);

      if($user['role'] == "servicer")
      {
                
               $profileQuery = "UPDATE `servicer_profiles` SET `category_id`='$category',`address`='$address',`profile_image`='$profileImage'' WHERE user_id = $id";
               $resultprofile = mysqli_query($connection, $profileQuery);
               $data = [
                    'message' => "Profile update successfully",
                ];  

      }
      else
      {
          $profileQuery = "UPDATE `servicer_profiles` SET `address`='$address',`profile_image`='$profileImage'' WHERE user_id = $id";
          $resultprofile = mysqli_query($connection, $profileQuery);
          $data = [
               'message' => "Profile update successfully",
           ]; 
      }   
        
  }
  else
  {
       $data = [
                'message' => "User not found",
            ];  
  }
 
  
  header('Content-Type: application/json');
  echo json_encode($data);
}
