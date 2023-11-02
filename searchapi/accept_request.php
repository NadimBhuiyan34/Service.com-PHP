<?php
require '../config.php';
if($_POST['verify'] == 'acceptrequest')
{
    $id = $_POST['id'];
    $status = $_POST['status'];
   
        $checkSql = "UPDATE `service_requests` SET `status`='$status', `updated_at`= NOW() WHERE id = $id";

        $result = mysqli_query($connection, $checkSql);

        if($result)
        {
            $data = [
                'message' => "Request status updated",
            ]; 
        }
        else
        {
            $data = [
                'message' => "Something is wrong",
            ]; 
        }
   
    
   
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>