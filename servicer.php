<?php
session_start(); // Start the session
include($_SERVER['DOCUMENT_ROOT'] . '/Service.com-PHP/config.php');
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
    <title>Serive.com</title>
    <link rel="icon" href="" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
    <!-- header -->

    <?php
    include_once($documentRoot . "/frontend/includes/layouts/header.php");
    ?>

    <div class="container">
        <div class="row mt-3">

            <div class="col-4 col-md-2 text-center border">
                <div class="p-2">
                    <a href="">
                        <img src="" alt="" style="width:100px;height:100px">
                    </a>
                    <span class="d-block d-md-inline fw-bold d-md-block">Name</span>
                </div>
            </div>

        </div>


        <!-- js -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
        <!-- Vendor JS Files -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>