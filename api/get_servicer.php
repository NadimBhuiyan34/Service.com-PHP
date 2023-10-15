<?php
require '../config.php';
if($_POST['verify'] == 'servicer')
{
 $category_id = $_POST['id'];
 $user_id = $_POST['user_id']; 

if ($user_id != null) {
    $userSQL = "SELECT `address` FROM `user_profiles` WHERE user_id = '$user_id'";
    $users = mysqli_query($connection, $userSQL);
    $row = mysqli_fetch_assoc($users);
$userAddress = $row['address'];

// Extract the middle part of the user address
$userAddressParts = explode(',', $userAddress);
if (count($userAddressParts) >= 2) {
    $userMiddlePart = trim($userAddressParts[1]);
} else {
    $userMiddlePart = '';
}
  
$servicerQuery = "SELECT users.*, servicer_profiles.*, COALESCE(AVG(reviews.rating_point), 0) AS average_rating
FROM users 
JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
WHERE servicer_profiles.category_id = $category_id 
  AND servicer_profiles.address LIKE '%$userMiddlePart%'
  AND users.status = 'Active'
GROUP BY servicer_profiles.user_id";

} else {
    $servicerQuery = "SELECT users.*, servicer_profiles.*, AVG(reviews.rating_point) AS average_rating
FROM users 
JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
WHERE servicer_profiles.category_id = $category_id 
  AND users.status = 'Active'
GROUP BY servicer_profiles.user_id";

    
}


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