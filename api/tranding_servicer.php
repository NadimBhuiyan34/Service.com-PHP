<?php
require '../config.php';
if($_POST['verify'] == 'tranding_servicer')
{


    $servicerQuery = "SELECT users.*, servicer_profiles.*, AVG(reviews.rating_point) AS average_rating
    FROM users 
    JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
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