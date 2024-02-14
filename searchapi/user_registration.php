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
        // $otp = mt_rand(100000, 999999); // Generates a random six-digit OTP
        function generateOTP($length = 6) {
            $otp = "";
            $characters = "0123456789";
            $charLength = strlen($characters);
            for ($i = 0; $i < $length; $i++) {
                $otp .= $characters[rand(0, $charLength - 1)];
            }
            return $otp;
        }
        
        // Replace with your API endpoint
        $url = "https://api.exalter.cc/onetomany";
        
        // Generate OTP
        $otp = generateOTP();
        
        // Dynamic contact number (replace this with the actual dynamic contact)
          // Example contact number
        
        // Payload for API request
        $data = [
            "acode" => "30000026",
            "api_key" => "64f0fd48f66567c08c0a827d53ec00b96b4c4ea5",
            "senderid" => "85228777010",
            "type" => "text",
            "msg" => "Your OTP is: " . $otp,
            "contacts" =>  $mobile,
            "transactionType" => "T",
            "contentID" => ""
        ];
        
        // Initialize cURL session
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute cURL session and fetch the response
        $response = curl_exec($ch);
        
        // Close cURL session
        curl_close($ch);

        
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
