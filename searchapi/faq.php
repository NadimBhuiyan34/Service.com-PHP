<?php
require '../config.php';
if($_POST['verify'] == 'faq')
{
     
        
        $fetchQuery = "SELECT * FROM `advertises`";

        $advertises = mysqli_query($connection, $fetchQuery );

        if($advertises)
        {
            $data = array();
          while ($advertise = mysqli_fetch_assoc($advertises)) {
            $data[] = $advertise;
        }
        }
        else
        {
            $data = [
                'message' => "Something is wrong",
            ]; 
        }
   
    
   
    header('Content-Type: application/json');
    echo json_encode($data);

}
?>