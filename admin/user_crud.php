<?php
// edit
require 'config.php';
session_start();
require 'config.php';
if(!isset( $_SESSION['user_id']))
{
  header("Location: index.php");
}
if (isset($_POST['profileUpdate']))
{


       if (!empty($_POST['imageFile'])) {
             $image=$_POST['image'];
             $imageFileBase64 = $_POST['imageFile'];
            
             $imageFileOfTransactionProof = base64_decode($imageFileBase64);
		file_put_contents("../admin/public/profile/".$image, $imageFileOfTransactionProof);
            
        }
       
       
    $id=$_POST['id'];
    $image=$_POST['image'];
    $status=$_POST['status'];
    $name = $_POST['name'];
    $role = $_POST['role'];
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

      $updateQuery = "UPDATE `users` SET `name`='$name',`status`='$status' WHERE id = '$id'";
      $resultUser = mysqli_query($connection, $updateQuery);

      if($user['role'] == "servicer")
      {
                
               $profileQuery = "UPDATE `servicer_profiles` SET `category_id`='$category_id', `address`='$address',`experience`='$experience', `biography`='$biography', `profile_image`='$image' WHERE user_id = '$id'";

               if(mysqli_query($connection, $profileQuery))
               {
                $message = "Profile Update Successfully.";

                // Redirect to the index.php page with the message
                header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
                exit;
               }
              
      }
      else
      {
          $profileQuery = "UPDATE `user_profiles` SET `address`='$address', `profile_image`='$image' WHERE user_id = '$id'";
          if(mysqli_query($connection, $profileQuery))
          {
            $message = "Profile Update successfully.";

            // Redirect to the index.php page with the message
            header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
            exit;
          }
         
         
      }   
        
  }
  else
  {
    $message = "User Not Found.";

    // Redirect to the index.php page with the message
    header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
    exit;
  }
 
  
  header('Content-Type: application/json');
  echo json_encode($data);
}
// delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $id = $_POST['user_id'];
        $role = $_POST['role'];
        $query = "DELETE FROM `users` WHERE id = $id";
        if (mysqli_query($connection,  $query)) {
            $message = "Record delete successfully.";

            // Redirect to the index.php page with the message
            header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
            exit;
        } else {
            $message = "Something is wrong.";

            // Redirect to the index.php page with the message
            header("Location: users.php?message=" . urlencode($message) . "&role=" . urlencode($role));
            exit;
        }
    }
}
?>