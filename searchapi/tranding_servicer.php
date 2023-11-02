<?php
require '../config.php';
if($_POST['verify'] == 'tranding_servicer')
{


    $servicerQuery = "SELECT users.id As user_id, users.name, users.mobile, users.created_at, servicer_profiles.experience,servicer_profiles.address, servicer_profiles.biography, servicer_profiles.profile_image, AVG(reviews.rating_point) AS average_rating, categories.title AS category_title
FROM users
JOIN servicer_profiles ON users.id = servicer_profiles.user_id
LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id
LEFT JOIN categories ON servicer_profiles.category_id = categories.id
WHERE users.status = 'Active'
GROUP BY servicer_profiles.user_id
ORDER BY average_rating DESC
LIMIT 10;

    ";


    $servicers = mysqli_query($connection, $servicerQuery);
    
    if($servicers)
    {
        $data = array();
        while ($row = mysqli_fetch_assoc($servicers)) {
             
             $data[] = $row;
        }
        
    }
    header('Content-Type: application/json');
    echo json_encode($data);

}


?>