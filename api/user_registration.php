<?php

 
require '../config.php';
if($_POST['verify']=="idea")
{
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $category_id = $_POST['category'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $otp = mt_rand(1000, 9999);

    if($role == "servicer")
    {
        $queryUser = "INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','','$mobile','$otp','$role','Active')";
        $userRegister = mysqli_query($connection, $queryUser);

        $query = "SELECT id FROM users WHERE mobile = $mobile";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','','$category_id','$address','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            $data = [
                'mobile' => $mobile,
            ];

    }
    else if($role == "user")
    {
        $queryUser = "INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','','$mobile','$otp','$role','Active')";
        $userRegister = mysqli_query($connection, $queryUser);

        $query = "SELECT id FROM users WHERE mobile = $mobile";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','','','$address','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            $data = [
                'mobile' => $mobile,
            ];

    }
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>