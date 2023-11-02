<?php
require '../config.php';
if($_POST['verify'] == 'rating')
{
    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $message= $_POST['message']??'';
    $point = $_POST['point'];
    $queryCheck = "SELECT `id` FROM `reviews` WHERE user_id = $user_id AND servicer_id = $servicer_id";
    $result1 = mysqli_query($connection, $queryCheck);
    
    if(mysqli_num_rows($result1)>0)
    {
        $row = mysqli_fetch_assoc($result1);
        $id = $row['id'];
        $checkSql = "UPDATE `reviews` SET `rating_point`='$point', `message`='$message' WHERE id = $id";
        $result = mysqli_query($connection, $checkSql);
    }
    else
    {
        $checkSql = "INSERT INTO `reviews`(`user_id`, `service_id`, `servicer_id`, `message`, `rating_point`) VALUES ('$user_id','8','$servicer_id','$message','$point')";

        $result = mysqli_query($connection, $checkSql);
    }

    

    if($result)
    {
         
        $checkSql1 = "SELECT COUNT(*) AS total_rows, SUM(`rating_point`) AS total_rating FROM `reviews` WHERE servicer_id = '$servicer_id'";
        $result1 = mysqli_query($connection, $checkSql1);

        $row = mysqli_fetch_assoc($result1);
        $totalRows = $row['total_rows'];
        $totalRating = $row['total_rating'];

        if ($totalRows > 0) {
            $percentage = ($totalRating / $totalRows);
            $data = $percentage;

        } else {
             // Avoid division by zero
             $data = 0;
        }
 
    }

    header('Content-Type: application/json');
    echo json_encode($data);

}
