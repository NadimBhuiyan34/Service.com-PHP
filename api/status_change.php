<?php
require '../config.php';
if($_POST['verify'] == 'statuschange')
{
    
    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $role = $_POST['role'];
    
    if($role == 'user')
    {
       
    }
    else
    {
        $profileQuery = "UPDATE `service_requests` SET `status`='$status' WHERE user_id = $user_id AND servicer_id = $servicer_id AND status = 'pending'";
    }
    

    header('Content-Type: application/json');
    echo json_encode($data);

}
?>