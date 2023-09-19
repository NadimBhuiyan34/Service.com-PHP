<?php
require '../config.php';
if($_POST['verify'] == "location")
{

    $id=$_POST['id'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $let = $_POST['let'];
    $long = $_POST['long'];
    $manuallyAddress = $_POST['address'];
    $data1 = array(
        'city' => $city,
        'area' => $area,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'address' => $manuallyAddress
    );
   
    if(isset($_POST['fullAddress']))
    {
        $address = $_POST['fullAddress'];
     
    }
    else
    {
        $address = json_encode($data1);
    }
    
 
    $query = "SELECT role FROM users WHERE id = '$id'";
    $result =  $resultProfile = mysqli_query($connection, $query);
  if ($result->num_rows > 0) {
      
      $user = $result->fetch_assoc();

      

      if($user['role'] == "servicer")
      {
                
               $profileQuery = "UPDATE `servicer_profiles` SET `address`='$address'' WHERE user_id = $id";
               $resultprofile = mysqli_query($connection, $profileQuery);
               if($resultprofile)
               {
                $data = [
                    'message' => "Location update successfully",
                ];
               }
                

      }
      else
      {
          $profileQuery = "UPDATE `user_profiles` SET `address`='$address'' WHERE user_id = $id";
          $resultprofile = mysqli_query($connection, $profileQuery);
          if($resultprofile)
          {
           $data = [
               'message' => "Location update successfully",
           ];
          }
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
