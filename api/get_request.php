<?php
require '../config.php';
if($_POST['verify'] == 'request')
{
    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $checkSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id ' AND servicer_id = '$servicer_id' AND status = 'pending'";

    $result = mysqli_query($connection, $checkSql);

    if(mysqli_num_rows($result)>0)
    {
        $data = [
            'message' => "Request Allready Submitted",
        ]; 
    }
    else
    {
        $servicerQuery = "INSERT INTO `service_requests`(`user_id`, `servicer_id`, `status`, ) VALUES ('$user_id','$servicer_id','pending')";
        $request = mysqli_query($connection, $servicerQuery);
        
        if($request)
        {
            $data = [
                'message' => "Request Submitted Successfully",
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