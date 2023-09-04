<?php


require '../config.php';
if ($_POST['verify'] == "idea") {
    $mobile = $_POST['mobile']; // Sanitize input
    $query = "SELECT id FROM users WHERE mobile = $mobile";
    $userCheck = mysqli_query($connection, $query);
    if (mysqli_num_rows($userCheck) > 0) {

        $data = [
            'message' => 'This mobile number is alrady exits'
        ];
    } else {

        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $category_title = $_POST['category'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $otp = mt_rand(1000, 9999);


        $queryUser = "INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','nadim@gmail.com','$mobile','$otp','$role','Active')";
        $userRegister = mysqli_query($connection, $queryUser);

        $query = "SELECT id FROM users WHERE mobile = $mobile";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        if ($role == "servicer") {

            $categoryQuery = "SELECT `id` FROM `categories` WHERE title = $category_title ";
            $category = mysqli_query($connection,  $categoryQuery);
            $row = mysqli_fetch_assoc($category);
            $category_id = $row['id'];

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','2','$category_id','$address','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            $data = [
                'mobile' => $mobile,
            ];
        } else {
            $queryUserProfile = "INSERT INTO `user_profiles`(`user_id`,`address`,`profile_image`) VALUES ('$id','$address','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            $data = [
                'mobile' => $mobile,
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
