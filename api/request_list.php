<?php
require '../config.php';
if($_POST['verify'] == 'requestlist')
{

    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    if($role == 'user')
    {
        $listSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id"; 
        $result = mysqli_query($connection, $listSql);

        if($result)
        {
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {   
                  $id = $row['servicer_id'];
                  $sql = "SELECT users.*, user_profiles.* FROM users JOIN user_profiles ON users.id = user_profiles.user_id WHERE users.id = $id";
                  
                  $profile_result = mysqli_query($connection, $sql);
                  if ($profile_result) {
                    // Fetch the user profile data and add it to the $data array
                    while ($profile_row = mysqli_fetch_assoc($profile_result)) {
                        $data[] = $profile_row;
                    }
                } else {
                    $data = [
                        'message' => "no data here",
                    ]; 
                }
            }
        }

    }
    else
    {

    }
   
    
    

    // if(mysqli_num_rows($result)>0)
    // {
    //     $data = [
    //         'message' => "Request Allready Submitted",
    //     ]; 
    // }
    // else
    // {
    //     $servicerQuery = "INSERT INTO `service_requests`(`user_id`, `servicer_id`, `status`, ) VALUES ('$user_id','$servicer_id','pending')";
    //     $request = mysqli_query($connection, $servicerQuery);
        
    //     if($request)
    //     {
    //         $data = [
    //             'message' => "Request Submitted Successfully",
    //         ]; 
    //     }
    //     else
    //     {
    //         $data = [
    //             'message' => "Something is wrong",
    //         ]; 
    //     }
    // }

   
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>