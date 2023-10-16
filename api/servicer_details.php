<?php
require '../config.php';
if($_POST['verify'] == 'servicer_details')
{
  
  $user_id = $_POST['user_id']; 

 
 
   $servicerQuery = "SELECT * FROM `reviews` WHERE servicer_id = '$user_id'";


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