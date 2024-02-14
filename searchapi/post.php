<?php
require '../config.php';
if ($_POST['verify'] == "post") {
    
    
    if (!empty($_POST['imageFile'])) {
        $image=$_POST['image'];
        $imageFileBase64 = $_POST['imageFile'];
       
        $imageFileOfTransactionProof = base64_decode($imageFileBase64);
   file_put_contents("../admin/public/post/".$image, $imageFileOfTransactionProof);
       
   }
    
    $user_id = $_POST["user_id"];
    $description = $_POST["description"];
    $rate = $_POST["rate"];
    $image=$_POST['image'];

    $sql = "INSERT INTO `posts`(`user_id`, `description`, `rate`, `image`, `created_at`) 
    VALUES ('$user_id', '$description', '$rate', '$image', NOW())";
     if ($conn->query($sql) === TRUE) {
        $data = [
            'message' => "Post Created Successfully",
        ];
    } else {
        $data = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
}
