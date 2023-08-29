<?php
header('Content-Type: application/json');

require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   if($_POST['data']=='category' && $_POST['verify']=='idea')  
   {
    mysqli_set_charset($connection, 'utf8');

 
    $query = "SELECT * FROM categories ORDER BY id DESC";
    $result = mysqli_query($connection, $query);
     $data = array();
     $baseUrl = 'https://otp799999.000webhostapp.com/admin/public/category/';

     while ($row = mysqli_fetch_assoc($result)) {
         // Prepend base URL to banner_image
         $row['banner_image'] = $baseUrl . $row['banner_image'];
     
         $data[] = $row;
     }
     echo json_encode($data);
   } 
     
   if($_POST['data']=='service' && $_POST['verify']=='idea')  
   {
    mysqli_set_charset($connection, 'utf8');

 
    $query = "SELECT * FROM services ORDER BY id DESC";
    $result = mysqli_query($connection, $query);

     $data = array();
     while ($row = mysqli_fetch_assoc($result)) {
     $data[] = $row;
      }
  echo json_encode($data);
   } 
}
