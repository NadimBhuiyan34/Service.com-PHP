<?php
header('Content-Type: application/json');

require '../config.php';
  // get category data
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
         
        if($_POST['data']=='categories' && $_POST['verify']=='idea')  
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
          //  get service
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
           //get specific category data with service
        if($_POST['data']=='category')  
        {
            $categoryId = $_POST['id'];
            $query = "SELECT categories.*, services.*
            FROM categories
            LEFT JOIN services ON categories.id = services.category_id
            WHERE categories.id = $categoryId";
            $result = mysqli_query($connection, $query);
            if ($result) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode($data); // Output data as JSON
            } else {
                echo json_encode(array("error" => "No data found for the selected category."));
            }
        }
}
 

