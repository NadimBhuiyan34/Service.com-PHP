<?php
require '../config.php';
if($_POST['verify'] == "profileUpdate")
{

      

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
    // $image = $image ?? '';
    
    $query = "SELECT role FROM users WHERE id = '$id'";
    $resultProfile = mysqli_query($connection, $query);
    
        
  if ($resultProfile ->num_rows > 0) {
      
      $user = $resultProfile->fetch_assoc();

      $updateQuery = "UPDATE `users` SET `name`='$name' WHERE id = '$id'";
      $resultUser = mysqli_query($connection, $updateQuery);

      if($user['role'] == "servicer")
      {
             
    $category = $_POST['category'];
    $biography = $_POST['biography'];
    $experience = $_POST['experience'];
                $categorySql = "SELECT `id` FROM `categories` WHERE title = '$category'";
            $resultCategory = mysqli_query($connection, $categorySql);

            $categoryId = $resultCategory->fetch_assoc();
            $category_id = $categoryId['id'];
               $profileQuery = "UPDATE `servicer_profiles` SET `category_id`='$category_id', `address`='$address',`experience`='$experience', `biography`='$biography', `profile_image`='$image' WHERE user_id = '$id'";

             if(mysqli_query($connection, $profileQuery))
               {
                $data = [
                    'message' => "Profile update successfully",
                ];  
               }
      }
      else
      {
          $profileQuery = "UPDATE `user_profiles` SET `address`='$address', `profile_image`='$image' WHERE user_id = '$id'";
         if(mysqli_query($connection, $profileQuery))
          {
            $data = [
                'message' => "Profile update successfully",
            ]; 
          }
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
