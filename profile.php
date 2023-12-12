<?php
session_start(); // Start the session
include('config.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// user profile data fetch
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
if ($role == 'user') {
    $userQuery = "
    SELECT 
        users.id AS user_id, 
        users.name, 
        users.mobile, 
        users.created_at, 
        user_profiles.address,     
        user_profiles.profile_image
    FROM 
        users
    JOIN 
        user_profiles ON users.id = user_profiles.user_id
    WHERE users.id = $user_id
    GROUP BY 
        users.id, 
        users.name, 
        users.mobile, 
        users.created_at,   
        user_profiles.address, 
        user_profiles.profile_image
";
$users = mysqli_query($connection, $userQuery);
$user = mysqli_fetch_assoc($users);
;
} else if ($role == 'servicer') {
    $servicerQuery = "
    SELECT 
        users.id AS user_id, 
        users.name, 
        users.mobile, 
        users.created_at, 
        servicer_profiles.experience,
        servicer_profiles.address, 
        servicer_profiles.area, 
        servicer_profiles.biography, 
        servicer_profiles.profile_image, 
        AVG(reviews.rating_point) AS average_rating, 
        categories.title AS category_title
    FROM 
        users
    JOIN 
        servicer_profiles ON users.id = servicer_profiles.user_id
    LEFT JOIN 
        reviews ON servicer_profiles.user_id = reviews.servicer_id
    LEFT JOIN 
        categories ON servicer_profiles.category_id = categories.id
    WHERE users.id = $user_id

    GROUP BY 
        users.id, 
        users.name, 
        users.mobile, 
        users.created_at, 
        servicer_profiles.experience,
        servicer_profiles.address, 
        servicer_profiles.area, 
        servicer_profiles.biography, 
        servicer_profiles.profile_image,
        categories.title";
    $servicers = mysqli_query($connection, $servicerQuery);
    $servicer = mysqli_fetch_assoc($servicers);
}

// servicer profile update
if(isset($_POST['servicerUpdate']))
{
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == UPLOAD_ERR_OK) {
        // Specify the directory where you want to store the uploaded file
        $targetDir = "frontend/image/profile/";
    
        // Get the file extension
        $fileExtension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
    
        // Generate a unique name for the file
        $profileName = "profile_" . time() . "." . $fileExtension;
    
        $targetFilePath = $targetDir . $profileName;
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath);
    } else {
        // Handle the case where no file is uploaded or an error occurred
        $profileName = $_POST['old_image']; // You can set a default or handle this case based on your requirements
    }
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $mobile = $_POST['phone'];
    $about = $_POST['about'];
    $category = $_POST['category'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];
    $area = $_POST['area'];

    $userUpdate = "UPDATE `users` SET `name`=?, `mobile`=? WHERE id = ?";
    $userStmt = mysqli_prepare($connection, $userUpdate);
    mysqli_stmt_bind_param($userStmt, "ssi", $name, $mobile, $user_id);
    
    // Servicer profile update query
    $servicerProfileUpdate = "UPDATE `servicer_profiles` SET `category_id`=?, `address`=?, `area`=?,`experience`=?, `biography`=?, `profile_image`=? WHERE user_id = ?";
    $servicerProfileStmt = mysqli_prepare($connection, $servicerProfileUpdate);
    mysqli_stmt_bind_param($servicerProfileStmt, "isssssi", $category, $address, $area, $experience, $about, $profileName, $user_id);
    
    // Start a transaction
    mysqli_begin_transaction($connection);
    
    try {
        // Execute user update
        if (mysqli_stmt_execute($userStmt)) {
            // Execute servicer profile update
            if (mysqli_stmt_execute($servicerProfileStmt)) {
                // Both queries executed successfully, commit the transaction
                mysqli_commit($connection);
              
                $message = "Profile update successfull";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;

            } else {
                // Rollback the transaction if servicer profile update fails
                mysqli_rollback($connection);
                $message = "Profile update Fail";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;
            }
        } else {
            // Rollback the transaction if user update fails
            mysqli_rollback($connection);
            $message = "Profile update Fail";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;
        }
    } catch (Exception $e) {
        // Handle any exceptions and rollback the transaction
        mysqli_rollback($connection);
        echo "An error occurred: " . $e->getMessage();
    } finally {
        // Close the statements
        mysqli_stmt_close($userStmt);
        mysqli_stmt_close($servicerProfileStmt);
    }
}
// user profile update

if(isset($_POST['userUpdate']))
{
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == UPLOAD_ERR_OK) {
        // Specify the directory where you want to store the uploaded file
        $targetDir = "frontend/image/profile/";
    
        // Get the file extension
        $fileExtension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
    
        // Generate a unique name for the file
        $profileName = "profile_" . time() . "." . $fileExtension;
    
        $targetFilePath = $targetDir . $profileName;
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath);
    } else {
        // Handle the case where no file is uploaded or an error occurred
        $profileName = $_POST['old_image']; // You can set a default or handle this case based on your requirements
    }
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $mobile = $_POST['phone'];
   
    $address = $_POST['address'];
   

    $userUpdate = "UPDATE `users` SET `name`=?, `mobile`=? WHERE id = ?";
    $userStmt = mysqli_prepare($connection, $userUpdate);
    mysqli_stmt_bind_param($userStmt, "ssi", $name, $mobile, $user_id);
    
    // Servicer profile update query
    $userProfileUpdate = "UPDATE `user_profiles` SET `address`=?, `profile_image`=? WHERE user_id = ?";
    $userProfileStmt = mysqli_prepare($connection, $userProfileUpdate);
    mysqli_stmt_bind_param($userProfileStmt, "ssi",  $address, $profileName, $user_id);
    
    // Start a transaction
    mysqli_begin_transaction($connection);
    
    try {
        // Execute user update
        if (mysqli_stmt_execute($userStmt)) {
            // Execute servicer profile update
            if (mysqli_stmt_execute($userProfileStmt)) {
                // Both queries executed successfully, commit the transaction
                mysqli_commit($connection);
              
                $message = "Profile update successfull";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;

            } else {
                // Rollback the transaction if servicer profile update fails
                mysqli_rollback($connection);
                $message = "Profile update Fail";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;
            }
        } else {
            // Rollback the transaction if user update fails
            mysqli_rollback($connection);
            $message = "Profile update Fail";
        
                header("Location: profile.php?message=" . urlencode($message));
                exit;
        }
    } catch (Exception $e) {
        // Handle any exceptions and rollback the transaction
        mysqli_rollback($connection);
        echo "An error occurred: " . $e->getMessage();
    } finally {
        // Close the statements
        mysqli_stmt_close($userStmt);
        mysqli_stmt_close($userProfileStmt);
    }
}

// change password

if(isset($_POST['changePassword']))
{
    $user_id = $_POST['user_id'];
    $currentPassword = md5($_POST['currentPassword']);
     
    $newPassword = $_POST['newPassword'];
    $renewPassword = $_POST['renewPassword'];
    
    // Assuming you have a database connection named $connection
    
    // Check if the new password and re-entered password match
    if ($newPassword == $renewPassword) {
        // Retrieve the current password hash from the database
        $userQuery = "SELECT `password` FROM `users` WHERE id = ?";
        $userStmt = mysqli_prepare($connection, $userQuery);
        mysqli_stmt_bind_param($userStmt, "i", $user_id);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);
    
        if ($userResult) {
            $userData = mysqli_fetch_assoc($userResult);
            
            // Verify if the current password matches the one in the database
            if ($currentPassword === $userData['password']) {
                // Hash the new password using md5()
                $md5NewPassword = md5($newPassword);
                  
                // Update the password in the database
                $updateQuery = "UPDATE `users` SET `password` = ? WHERE id = ?";
                $updateStmt = mysqli_prepare($connection, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "si", $md5NewPassword, $user_id);
                mysqli_stmt_execute($updateStmt);
    
                if (mysqli_stmt_affected_rows($updateStmt) > 0) {
                    // Password updated successfully
                    $message = "Password changed successfully!";
                } else {
                    // Error updating password
                    $message = "Error changing password. Please try again.";
                }
    
                // Close the update statement
                mysqli_stmt_close($updateStmt);
            } else {
                // Current password does not match
                $message = "Current password is incorrect.";
            }
        } else {
            // Error retrieving current password
            $message = "Error retrieving current password. Please try again.";
        }
    
        // Close the user statement
        mysqli_stmt_close($userStmt);
    } else {
        // New password and re-entered password do not match
        $message = "New password and re-entered password do not match.";
    }
    
    // Redirect with the appropriate message
    header("Location: profile.php?message=" . urlencode($message));
    exit;
}
?>

<!-- Your HTML content here -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Search</title>


    <link rel="icon" href="" type="image/x-icon">
    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="frontend/includes/css/footer.css">
    <style>
    .password-mismatch {
      border-color: red !important;
    }

    .password-match {
      border-color: green !important;
    }
  </style>
</head>

<body style="background-color: rgb(224, 241, 253);">
    <!-- header -->




    <?php include_once("header.php"); ?>
    <section>
        <img class="contactus d-none d-lg-block d-xl-block" src="https://community.khoros.com/t5/image/serverpage/image-id/164425iE641E9340947FE57/image-size/large/is-moderation-mode/true?v=v2&px=999" alt="" style="height:400px;width:100%">

        <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 77%, 48%);">
            <h2 class="text-center p-2 text-white">Profile</h2>
        </div>
        <!-- end slider -->
    </section>
  <!-- alert message -->
  <?php include_once "frontend/includes/layouts/message/alert.php" ?>
  <!-- end alert message -->

    <main id="main" class="main mt-5 mb-5">

      <?php
       if($_SESSION['role'] == 'user')
       {
        include_once('frontend/includes/page/user_profile.php');
       }
       else if($_SESSION['role'] == 'servicer')
       {
        include_once('frontend/includes/page/servicer_profile.php');
       }
      
      ?>
        

    </main><!-- End #main -->







    <?php include_once("footer.php"); ?>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        // Function to hide the alert and progress bar after a delay
        function hideAlertAndProgressBar() {
            const duration = 5000; // 5000ms = 5 seconds
            const progressBar = $(".progress-bar");

            let progress = 0;
            const interval = 100; // 100ms interval for updating progress
            const steps = duration / interval;

            const updateProgressBar = setInterval(function() {
                progress += 100 / steps;
                progressBar.css("width", progress + "%");

                if (progress >= 100) {
                    clearInterval(updateProgressBar);
                    $(".fixed-alert").fadeOut(500, function() {
                        $(this).remove(); // Remove the entire .fixed-alert container
                    });
                }
            }, interval);
        }

        // Call the function when the page loads
        hideAlertAndProgressBar();
    </script>
    <!-- js -->
    <script>
    function checkPasswordMatch() {
      var newPassword = document.getElementById('newPassword').value;
      var renewPassword = document.getElementById('renewPassword').value;
      var changePasswordBtn = document.getElementById('changePasswordBtn');

      if (newPassword !== renewPassword) {
        // Passwords do not match
        document.getElementById('renewPassword').classList.add('password-mismatch');
        changePasswordBtn.disabled = true;
      } else {
        // Passwords match
        document.getElementById('renewPassword').classList.remove('password-mismatch');
        document.getElementById('renewPassword').classList.add('password-match');
        changePasswordBtn.disabled = false;
      }
    }
  </script>
</body>

</html>