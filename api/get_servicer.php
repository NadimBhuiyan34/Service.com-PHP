<?php
if($_POST['verify'] == 'servicer')
{
    $category_id = $_POST['id'];
    $servicerQuery = "SELECT users.*, servicer_profiles.* FROM users JOIN servicer_profiles ON users.id = servicer_profiles.user_id WHERE servicer_profiles.category_id = $id";
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