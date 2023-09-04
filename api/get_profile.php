<?php
require '../config.php';
if($_POST['verify'] == "profile")
{
     
    $id=$_POST['id'];
    
    $query = "SELECT role FROM users WHERE id = '$id'";
    $result =  $resultProfile = mysqli_query($connection, $query);
 
 
  if ($result->num_rows > 0) {
      
      $user = $result->fetch_assoc();

      if($user['role'] == "servicer")
      {
                $sql = "SELECT users.*, servicer_profiles.* FROM users JOIN servicer_profiles ON users.id = servicer_profiles.user_id WHERE users.id = $id";
      
      }
      else
      {
           $sql = "SELECT users.*, user_profiles.* FROM users JOIN user_profiles ON users.id = user_profiles.user_id WHERE users.id = $id";
      }

      $users = mysqli_query($connection, $sql);
      if($users)
      {
        $data = array();
        while ($row = mysqli_fetch_assoc($users)) {
             
             $data[] = $row;
        }
      }
      else
      {
           $data = [
                'message' => "no data here",
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
?>