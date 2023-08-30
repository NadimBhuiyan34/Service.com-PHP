<?php
 include_once('config.php');
//    category service
    if(isset($_POST['categoryService']))
    {
       $id  = $_POST['id'];
       $query = "SELECT * FROM services WHERE category_id = $id ORDER BY id DESC";                       
       $data = mysqli_query($connection, $query);

       if ($data) {
        $services = array();
        while ($service = mysqli_fetch_assoc($data)) {
            $services[] = $service;
        }
        
        $res = [
            'status' => 'success',
            'services' => $services
            
        ];
        } else {
            $res = [
                'status' => 'fail',
                    
            ];
            
        }
        header('Content-Type: application/json');
        echo json_encode($res);
    }

        // register
 if (isset($_POST['registerRequest'])) {
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']); // Sanitize input
    $query = "SELECT id FROM users WHERE mobile = $mobile";
    $stmt = mysqli_prepare($connection, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $mobile); // Bind the mobile parameter
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {

            $res = [
                'status' => 'fail',
                'message' => 'User with the provided mobile number does not exist'
            ];

        } else {
           
        // profile image
        // if($profileImage = $_FILES['profileImage'])
        // {
        //     $profileImage = $_FILES['profileImage']['name'];
        //     $profileImageTmp = $_FILES['profileImage']['tmp_name']; 
        //     $profileImageDestination = "admin/public/profile/" . $profileImage;
        //     move_uploaded_file($profileImageTmp, $profileImageDestination);
        // }
        //  work image
        // if($_FILES['workImage'])
        // {
        //     $workImages = $_FILES['workImage'];
        //     $workImageNames = array();

        //     foreach ($workImages['tmp_name'] as $key => $tmp_name) {
        //         $workImage = $workImages['name'][$key];
        //         $workImageTmp = $tmp_name;
        //         $workImageNames[] = $workImage;
        //         $workImageDestination = "admin/public/workimage/" . $workImage;
        //         // $workImageDestinations[] = $workImageDestination;
                
        //         move_uploaded_file($workImageTmp, $workImageDestination);
        //     }
            
        // }

                // Convert array of image paths to comma-separated string
                // $workImageNamesJson = json_encode($workImageNames);

                // Sanitize and get form data
                $name = mysqli_real_escape_string($connection, $_POST['name']);
                $role = mysqli_real_escape_string($connection, $_POST['role']);
                $email = mysqli_real_escape_string($connection, $_POST['email']);
                $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
                $category_id = mysqli_real_escape_string($connection, $_POST['category']);
                $location = mysqli_real_escape_string($connection, $_POST['location']);
                $services = array_filter($_POST["services"]);
                $service_id = json_encode($services); 
                 
                // otp generate
                $otp = mt_rand(1000, 9999);
                //   query insert
                $queryUser="INSERT INTO `users`(`name`, `email`, `mobile`, `otp`, `role`, `status`) VALUES ('$name','$email','$mobile','$otp','$role','Active')";
                $resultUser=mysqli_query($connection,$queryUser);

                if($resultUser)
                {
                    $query = "SELECT id FROM users WHERE mobile = $mobile";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "s", $mobile);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id);

                    $queryUserProfile="INSERT INTO `servicer_profiles`(`user_id`, `service_id`, `category_id`, `location`, `experience`, `biography`, `profile_image`, `work_image`) VALUES ('$id','$service_id','$category_id','$location','','','','')";
                    $resultProfile=mysqli_query($connection,$queryUserProfile);
                    if($resultProfile)
                    {
                        $res = [
                            'status' => 'success',
                            'mobile' => $mobile,    
                        ];
                    }
                }
     
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($res);
    }
 
   



 


 
   