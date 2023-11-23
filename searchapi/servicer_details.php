<?php
require '../config.php';
if($_POST['verify'] == 'servicer_details')
{
 $user_id = $_POST['user_id'];

// $servicerQuery = "
//     SELECT 
//         users.name, 
//         users.mobile, 
//         servicer_profiles.address, 
//         servicer_profiles.experience, 
//         servicer_profiles.biography, 
//         servicer_profiles.profile_image, 
//         COALESCE(AVG(reviews.rating_point), 0) AS average_rating,
//         reviews.message, 
//         reviews.id, 
//         reviews.created_at
//     FROM reviews
//     INNER JOIN users ON reviews.servicer_id = users.id
//     INNER JOIN servicer_profiles ON reviews.servicer_id = servicer_profiles.user_id
//     WHERE reviews.servicer_id = '$user_id'
//     GROUP BY servicer_profiles.user_id, reviews.servicer_id;
// ";

 
 

$servicerQuery = "
 SELECT 
    reviews.id,
    reviews.message,
    reviews.rating_point,
    reviews.created_at,
    reviews.updated_at,
    reviewer_users.name AS reviewer_name,
    servicer_users.name AS servicer_name,
    servicer_users.mobile AS servicer_mobile,
    servicer_profiles.address AS servicer_address,
    COALESCE((
        SELECT AVG(sub_reviews.rating_point) 
        FROM reviews AS sub_reviews 
        WHERE sub_reviews.servicer_id = '$user_id'
    ), 0) AS average_rating
FROM reviews
JOIN users AS reviewer_users ON reviews.user_id = reviewer_users.id
JOIN users AS servicer_users ON reviews.servicer_id = servicer_users.id
JOIN servicer_profiles ON reviews.servicer_id = servicer_profiles.user_id
WHERE reviews.servicer_id = '$user_id'

";






    $servicers = mysqli_query($connection, $servicerQuery);
    
    if($servicers)
    {
        $data = array();
        while ($row = mysqli_fetch_assoc($servicers)) {
             
             $data[] = $row;
        }
        
    }
 else
    {
        $data = array();
        $data = [
            'message' => "Something is wrong",
           
        ];  
    }
    header('Content-Type: application/json');
    echo json_encode($data);

}


?>