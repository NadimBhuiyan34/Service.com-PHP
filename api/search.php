<?php
require '../config.php';
if($_POST['verify'] == 'search')
{
    
   
    header('Content-Type: application/json');
    echo json_encode($data);

}


?>