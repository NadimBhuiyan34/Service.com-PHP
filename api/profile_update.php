<?php
require '../config.php';
if($_POST['verify'] == "profileUpdate")
{

    //  if (isset($_FILES["profile"]) && $_FILES["profile"]["error"] == 0) {

    //       $uploadDir = "https://otp799999.000webhostapp.com/admin/public/profile/"; // Directory to store uploaded images
    //       $targetFile = $uploadDir . basename($_FILES["profile"]["name"]);
    //       $uploadOk = 1;
    //       $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
          
    //       $check = getimagesize($_FILES["profile"]["tmp_name"]);
          
    //      if ($check !== false) {
    //       if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {

    //           $imageName = $_FILES["profile"]["name"];
                      
    //       }  
     
    //      }  
          
         
    //   } 
   

       if (!empty($_POST['imageFile'])) {
             $image=$_POST['image'];
             $imageFileBase64 = $_POST['imageFile'];
            
             $imageFileOfTransactionProof = base64_decode($imageFileBase64);
		file_put_contents("../admin/public/profile/".$image, $imageFileOfTransactionProof);
            
        }
       
       
    $id=$_POST['id'];
    $image=$_POST['image'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $biography = $_POST['biography'];
    $experience = $_POST['experience'];
    // $image = $image ?? '';
    
    $query = "SELECT role FROM users WHERE id = '$id'";
    $resultProfile = mysqli_query($connection, $query);
    
   $categorySql = "SELECT `id` FROM `categories` WHERE title = '$category'";
    $resultCategory = mysqli_query($connection, $categorySql);
     
      $categoryId = $resultCategory->fetch_assoc();
      $category_id = $categoryId['id'];
      
  if ($resultProfile ->num_rows > 0) {
      
      $user = $resultProfile->fetch_assoc();

      $updateQuery = "UPDATE `users` SET `name`='$name' WHERE id = '$id'";
      $resultUser = mysqli_query($connection, $updateQuery);

      if($user['role'] == "servicer")
      {
                
               $profileQuery = "UPDATE `servicer_profiles` SET `category_id`='$category_id', `address`='$address',`experience`='$experience', `biography`='$biography', `profile_image`='$image' WHERE user_id = '$id'";

               $resultprofile = mysqli_query($connection, $profileQuery);
               $data = [
                    'message' => "Profile update successfully",
                ];  
      }
      else
      {
          $profileQuery = "UPDATE `user_profiles` SET `address`='$address', `profile_image`='$image' WHERE user_id = '$id'";
          $resultprofile = mysqli_query($connection, $profileQuery);
          $data = [
               'message' => "Profile update successfully",
           ]; 
      }   
        
  }
  else
  {
       $data = [
                'message' => "user not found",
            ];  
  }
 
  
  header('Content-Type: application/json');
  echo json_encode($data);
}
