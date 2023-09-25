<?php
require '../config.php';
if ($_POST['verify'] == 'servicer') {
    $category_id = $_POST['id'];
    $user_id = $_POST['id'];

    if($user_id != '')
    {
        $userSQL = "SELECT `address`,FROM `user_profiles` WHERE user_id = '$user_id'";
        $users = mysqli_query($connection, $userSQL);
        $row = mysqli_fetch_assoc($users);
        $address = $row['address'];
    
        $servicerQuery = "SELECT users.*, servicer_profiles.*, reviews.rating_point 
    FROM users 
    JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
    WHERE servicer_profiles.category_id = $id AND servicer_profiles.address = '$address'";
    
    }
    else
    {
        $servicerQuery = "SELECT users.*, servicer_profiles.*, reviews.rating_point FROM users JOIN servicer_profiles ON users.id = servicer_profiles.user_id WHERE servicer_profiles.category_id = $id";
    }

    $servicers = mysqli_query($connection, $servicerQuery);

    if ($servicers) {
        $data = array();
        while ($row = mysqli_fetch_assoc($servicers)) {

            $data[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($data);
}
