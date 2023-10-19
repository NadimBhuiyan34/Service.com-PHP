<?php
require '../config.php';
if($_POST['verify'] == 'report')
{
    $user_id = $_POST['user_id'];
    $report_id = $_POST['report_id'];
    $report = $_POST['report'];
   
        $reportSql = "INSERT INTO `reports`(`user_id`, `report_id`, `report`, `status`,) VALUES ('$user_id','$report_id','$report','pending')";

        $result = mysqli_query($connection, $reportSql);

        if($result)
        {
            $data = [
                'message' => "Your report submitted",
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