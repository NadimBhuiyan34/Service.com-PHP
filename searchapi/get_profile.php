<?php
require '../config.php';
if($_POST['verify'] == "profile")
{
     
    $id=$_POST['id'];
    
    $query = "SELECT role FROM users WHERE id = '$id'";
    $result =  $resultProfile = mysqli_query($connection, $query);
 
 
  if ($result->num_rows > 0) {
      
      $user = $result->fetch_assoc();

      if($user['role'] == "servicer")
      {
                // $sql = "SELECT users.*, servicer_profiles.* FROM users JOIN servicer_profiles ON users.id = servicer_profiles.user_id WHERE users.id = $id";
                $sql = "SELECT
    users.*,
    servicer_profiles.*,
    categories.title,
    AVG(reviews.rating_point) AS average_rating,
    TRIM(SUBSTRING_INDEX(servicer_profiles.address, ',', -1)) AS city,
    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(servicer_profiles.address, ',', -2), ',', 1)) AS area,
    TRIM(SUBSTRING_INDEX(servicer_profiles.address, ',', 2)) AS address
FROM
    users
JOIN servicer_profiles ON users.id = servicer_profiles.user_id
LEFT JOIN categories ON servicer_profiles.category_id = categories.id
LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id
WHERE
    users.id = $id
GROUP BY
    users.id;
";
      
      }
      else
      {
           $sql = "SELECT
    users.*,
    user_profiles.*,
    TRIM(SUBSTRING_INDEX(user_profiles.address, ',', -1)) AS city,
    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(user_profiles.address, ',', -2), ',', 1)) AS area,
    TRIM(SUBSTRING_INDEX(user_profiles.address, ',', 2)) AS address
FROM
    users
JOIN user_profiles ON users.id = user_profiles.user_id
WHERE
    users.id = $id;
";
      }

      $users = mysqli_query($connection, $sql);
      if($users)
      {
               $data = array();
        while ($row = mysqli_fetch_assoc($users)) {
             
             $data[] = $row;
        }
      }
      else
      {
           $data = [
                'message' => "no data here",
            ]; 
      }
  
        
  }
  else
  {
       $data = [
                'message' => "user not found",
            ];  
  }
 
  
  header('Content-Type: application/json');
  $json_data = json_encode($data);

    // Output or use the JSON data as needed
    echo $json_data;
}
?>