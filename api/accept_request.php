<?php
require '../config.php';
if($_POST['verify'] == 'acceptrequest')
{
    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $status = $_POST['status'];
    if($status == 'accepted')
    {
        $checkSql = "UPDATE `service_requests` SET `status`='accepted' WHERE user_id = $user_id AND servicer_id = $servicer_id And status = 'pending'";

        $result = mysqli_query($connection, $checkSql);

        if($result)
        {
            $data = [
                'message' => "Request accpeted",
            ]; 
        }
        else
        {
            $data = [
                'message' => "Something is wrong",
            ]; 
        }
    }
    else
    {
        $checkSql = "UPDATE `service_requests` SET `status`='completed' WHERE user_id = $user_id AND servicer_id = $servicer_id And status = 'accepted'";
        $result = mysqli_query($connection, $checkSql);

        if($result)
        {
            $data = [
                'message' => "Task Completed",
            ]; 
        }
        else
        {
            $data = [
                'message' => "Something is wrong",
            ]; 
        }
    }
    



   
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>