<?php
require '../config.php';
if($_POST['verify'] == 'requestlist')
{

    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $data = array();

    if ($role == 'user') {
        if($status == 'pending')
        {
             $listSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id' AND status = 'pending'";
             $result = mysqli_query($connection, $listSql);
        }
        else if($status == 'completed')
        {
             $listSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id' AND status = 'completed'";
             $result = mysqli_query($connection, $listSql); 
        }
        else
        {
            $listSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id' AND status = 'accepted'";
             $result = mysqli_query($connection, $listSql);  
        }
       

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['servicer_id'];
            $request_id = $row['id'];

$sql = "
    SELECT 
        users.name,
        users.mobile,
        servicer_profiles.address,
        servicer_profiles.experience,
        servicer_profiles.biography,
        servicer_profiles.profile_image,
        COALESCE(AVG(reviews.rating_point), 0) AS average_rating,
        service_requests.id,
        service_requests.status,
        service_requests.created_at,
        service_requests.updated_at
    FROM users 
    JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
    LEFT JOIN service_requests ON servicer_profiles.user_id = service_requests.servicer_id 
    WHERE users.id = $id AND service_requests.id = $request_id
    GROUP BY servicer_profiles.user_id, service_requests.id;
";


                $profile_result = mysqli_query($connection, $sql);

                if ($profile_result) {
                    // Fetch the user profile data and add it to the $data array
                    while ($profile_row = mysqli_fetch_assoc($profile_result)) {
                        $data[] = $profile_row;
                    }
                } else {
                    // Handle any errors that may occur during the profile query execution
                    $data[] = [
                        'message' => "No data available for user ID: $id",
                    ];
                }
            }
        } else {
            // Handle any errors that may occur during the service requests query execution
            $data = [
                'message' => "No service requests available for user ID: $user_id",
            ];
        }
    } else {
        
         if($status == 'pending')
        {
             $listSql = "SELECT * FROM `service_requests` WHERE servicer_id = '$user_id' AND status = 'pending'";
             $result = mysqli_query($connection, $listSql);
        }
        else if($status == 'completed')
        {
            $listSql = "SELECT * FROM `service_requests` WHERE servicer_id = '$user_id' AND status = 'completed'";
            $result = mysqli_query($connection, $listSql);
        }
        else
        {
            $listSql = "SELECT * FROM `service_requests` WHERE servicer_id = '$user_id' AND status = 'accepted'";
            $result = mysqli_query($connection, $listSql);
        }
        

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
$id = $row['user_id'];
$request_id = $row['id'];

$sql = "
    SELECT 
        users.name, 
        users.mobile, 
        user_profiles.address, 
        user_profiles.profile_image, 
        service_requests.id, 
        service_requests.status, 
        service_requests.created_at, 
        service_requests.updated_at
    FROM users
    JOIN user_profiles ON users.id = user_profiles.user_id
    LEFT JOIN service_requests ON user_profiles.user_id = service_requests.user_id
    WHERE users.id = '$id' AND service_requests.id = '$request_id'
    GROUP BY user_profiles.user_id;
";

               
                $profile_result = mysqli_query($connection, $sql);

                if ($profile_result) {
                    // Fetch the user profile data and add it to the $data array
                    while ($profile_row = mysqli_fetch_assoc($profile_result)) {
                        $data[] = $profile_row;
                    }
                } else {
                    // Handle any errors that may occur during the profile query execution
                    $data[] = [
                        'message' => "No data available for user ID: $id",
                    ];
                }
            }
        } else {
            // Handle any errors that may occur during the service requests query execution
            $data = [
                'message' => "No service requests available for user ID: $user_id",
            ];
        }
    }
   
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>