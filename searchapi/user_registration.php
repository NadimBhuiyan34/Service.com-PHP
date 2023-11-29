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
        $password = md5($_POST['password']);
        $category_title = $_POST['category'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $otp = mt_rand(100000, 999999); // Generates a random six-digit OTP

        $queryUser = "INSERT INTO `users`(`name`, `email`,`password`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','','$password','$mobile','$otp','$role','Unverify')";
        $userRegister = mysqli_query($connection, $queryUser);

        $query = "SELECT id FROM users WHERE mobile = '$mobile'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        if ($role == "servicer") {

            $categoryQuery = "SELECT `id` FROM `categories` WHERE title = '$category_title' ";
            $category = mysqli_query($connection,  $categoryQuery);
            $row = mysqli_fetch_assoc($category);
            $category_id = $row['id'];

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `address`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','8','$category_id','$address','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            if ($resultProfile) {
                $data = [
                    'mobile' => $mobile,
                    'id' => $id,
                ];
            } else {
                $data = [
                    'message' => "data not inserted",
                ];
            }
        } else {
            $queryUserProfile = "INSERT INTO `user_profiles`(`user_id`, `address`, `profile_image`) VALUES ('$id','$address','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            if ($resultProfile) {
                $data = [
                    'mobile' => $mobile,
                    'id' => $id,
                ];
            } else {
                $data = [
                    'message' => "data not inserted",
                ];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}



if ($_POST['verify'] == "otp") {

    $mobile = $_POST['otpMobile'];
    $submittedOTP = $_POST['otp'];


    $query = "SELECT * FROM users WHERE mobile = '$mobile' AND otp = '$submittedOTP'";
    $result =  $resultProfile = mysqli_query($connection, $query);


    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $id = $user['id'];
        $name = $user['name'];
        $role = $user['role'];

        if ($role == 'servicer') {
            $status = 'Pending';
        } else {
            $status = 'Active';
        }
        $data = [
            'id' => $id,
            'name' => $name,
        ];

        $updateQuery = "UPDATE `users` SET `status`='$status' WHERE id = $id";
        $result =  $resultProfile = mysqli_query($connection, $updateQuery);
    } else {
        $data = [
            'message' => "otp is wrong",
        ];
    }


    header('Content-Type: application/json');
    echo json_encode($data);
}
