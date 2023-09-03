<?php
include_once('config.php');
// register
if (isset($_POST['registerRequest'])) {
    $mobile = $_POST['mobile']; // Sanitize input
    $query = "SELECT id FROM users WHERE mobile = '$mobile'";
    $userCheck = mysqli_query($connection, $query);

    if (mysqli_num_rows($userCheck) > 0) {

        $res = [
            'status' => 'fail',
            'message' => 'This mobile number is already registered'
        ];
    } 
    else {


        // Sanitize and get form data
        $name = $_POST['name'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $category_id = $_POST['category'];
        $location = $_POST['location'];
        $services = array_filter($_POST["services"]);
        $service_id = json_encode($services);

        // otp generate
        $otp = mt_rand(1000, 9999);
        //   query insert
        $queryUser = "INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','$email','$mobile','$otp','$role','Active')";
        $resultUser = mysqli_query($connection, $queryUser);

        
            $query = "SELECT id FROM users WHERE mobile = $mobile";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];

            $queryUserProfile = "INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','2','$category_id','$location','','','','')";
            $resultProfile = mysqli_query($connection, $queryUserProfile);
            
                $res = [
                    'status' => 'success',
                    'mobile' => $mobile
                ];
             
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}
