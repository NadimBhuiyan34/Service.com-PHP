<?php
session_start(); // Start the session
include('config.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
if ($role == 'user') {
} else if ($role == 'servicer') {
    $servicerQuery = "
    SELECT 
        users.id AS user_id, 
        users.name, 
        users.mobile, 
        users.created_at, 
        servicer_profiles.experience,
        servicer_profiles.address, 
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
        servicer_profiles.biography, 
        servicer_profiles.profile_image,
        categories.title";
    $servicers = mysqli_query($connection, $servicerQuery);
    $servicer = mysqli_fetch_assoc($servicers);
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

</head>

<body style="background-color: rgb(224, 241, 253);">
    <!-- header -->




    <?php include_once("header.php"); ?>
    <section>
        <img class="contactus d-none d-lg-block d-xl-block" src="https://community.khoros.com/t5/image/serverpage/image-id/164425iE641E9340947FE57/image-size/large/is-moderation-mode/true?v=v2&px=999" alt="" style="height:400px;width:100%">

        <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 77%, 48%);">
            <h2 class="text-center p-2 text-white">Contact Us</h2>
        </div>
        <!-- end slider -->
    </section>

    <main id="main" class="main mt-5 mb-5">

      <?php
       if($_SESSION['role'] == 'user')
       {
        include_once('frontend/includes/page/user_profile.php');
       }
      
      ?>
        

    </main><!-- End #main -->







    <?php include_once("footer.php"); ?>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>