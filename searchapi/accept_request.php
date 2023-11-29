<?php
require '../config.php';

if ($_POST['verify'] == 'acceptrequest') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $confirmation_code = $_POST['code'];
     
    if ($status == 'accepted') {
        // Update status to 'accepted'
        $checkSql = "UPDATE `service_requests` SET `status`='$status', `updated_at`= NOW() WHERE id = $id";
    } else if ($status == 'completed') {
        // Check if the confirmation code matches
        $checkRequest = "SELECT `id` FROM `service_requests` WHERE id = $id AND confirmation_code = '$confirmation_code'";
        $confirm = mysqli_query($connection, $checkRequest);

        if (mysqli_num_rows($confirm) > 0) {
            // Update status to 'completed'
            $checkSql = "UPDATE `service_requests` SET `status`='$status', `completed_at`= NOW() WHERE id = $id";
        } else {
            // Handle the case where the confirmation code doesn't match
            $data = [
                'message' => "Invalid confirmation code",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit(); // Stop script execution
        }
    } else {
        // Update status to any other value
        $checkSql = "UPDATE `service_requests` SET `status`='$status' WHERE id = $id";
    }

    // Execute the SQL query
    if (mysqli_query($connection, $checkSql)) {
        $data = [
            'message' => "Request status updated",
        ];
    } else {
        $data = [
            'message' => "Something is wrong",
        ];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
