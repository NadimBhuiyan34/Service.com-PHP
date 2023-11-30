<?php
require 'config.php';
session_start(); // Start the session
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['contacts']))
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $message = $_POST["message"];
    
        $insertQuery = "INSERT INTO contact_users (name, email, mobile, message, status) VALUES ('$name', '$email', '$mobile', '$message', 'Unread')";

    
        if (mysqli_query($connection, $insertQuery)) {
            $message = "Successfully submitted";

        // Redirect to the index.php page with the message
        header("Location: contactus.php?message=" . urlencode($message));
        exit;
        }
         else {
           
                $message = "Something is wrong";
    
            // Redirect to the index.php page with the message
            header("Location: contactus.php?message=" . urlencode($message));
            exit;
       
        
    }
    
}
}
?>


<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>The Search-Contact us</title>
<link rel="icon" href="frontend/img/Logo-NPL.png" type="image/x-icon">

<!-- css -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  
  <link rel="stylesheet" href="frontend/includes/css/footer.css">


<!-- Google Fonts -->
<!-- <link rel="stylesheet" href="frontend/css/footer.css">
<link rel="stylesheet" href="frontend/css/main.css"> -->
<link rel="stylesheet" href="frontend/includes/css/contact.css">

</head>

<body class="sb-nav-fixed bg-white">
    <div id="wrapper">
        <?php include_once('header.php'); ?>






        <section id="">
            <!-- Slider -->

            <img class="contactus d-none d-lg-block d-xl-block" src="https://www.hurstbourne.org/wp-content/uploads/2018/06/contact-us_image.jpg" alt="" style="height:400px;width:100%">

            <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 77%, 48%);">
                <h2 class="text-center p-2 text-white">Contact Us</h2>
            </div>
            <!-- end slider -->
        </section>

        <section style="margin-top: 30px;">
            <h3 class="text-center fw-bold header-color">Contact with The Search | Corporate Office</h3>
            <hr>
        </section>
         
        <?php
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        ?>
            <div class="fixed-alert" style="position: fixed;top: 10px;right: 300px; z-index: 1000">
                <div class="alert text-white shadow" role="alert" style="background-color: green;">
                    <i class="fa-solid fa-check fa-bounce fa-2xl mr-2"></i>
                    <?php echo $message ?>

                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>

            <script>
                // Remove the message parameter from the URL on page load
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            </script>
        <?php
        }
        ?>



        <section class="">
            <div class="contact_info">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1 col-12">
                            <div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

                                <!-- Contact Item -->
                                <div class="contact_info_item d-flex flex-row align-items-center justify-content-start border-2 border-info rounded-3">
                                    <div class=""><img src="https://icones.pro/wp-content/uploads/2021/04/icone-de-telephone-portable-rouge.png" alt="" style="width:50px; height:50px"></div>
                                    <div class="contact_info_content">
                                        <div class="fw-bold">Phone</div>
                                        <div class="">
                                            +8801305795830<br>
                                            +8801305795830 
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Item -->
                                <div class="contact_info_item d-flex flex-row align-items-center justify-content-start border-2 border-info rounded-3">
                                    <div class=""><img src="https://seeklogo.com/images/G/gmail-icon-logo-9ADB17D3F3-seeklogo.com.png" alt="" style="width:50px; height:50px"></div>
                                    <div class="contact_info_content">
                                        <div class="fw-bold">Email</div>
                                        <div class="">search@gmail.com
                                        thesearch.net</div>
                                    </div>
                                </div>

                                <!-- Contact Item -->
                                <div class="contact_info_item d-flex flex-row align-items-center justify-content-start border-2 border-info rounded-3">
                                    <div class=""><img src="https://www.pngkit.com/png/full/18-185997_location-icon-png-vodafone-new-logo-png.png" alt="" style="width:50px; height:50px"></div>
                                    <div class="contact_info_content ">
                                        <div class=" pt-3 fw-bold">Address</div>
                                        <div class=" mb-3">Dhaka
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->

            <div class="contact_form text-center">

                <div class="container rounded-3" style="background-color: rgb(115, 165, 235);">

                    <div class="row shadow">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="contact_form_container">
                                <div class="contact_form_title text-center pt-2">Get in Touch</div>
                                <hr>

                                <form action="contactus.php" id="contact_form" method="POST">
                                    <div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
                                        <input type="text" id="contact_form_name" class="contact_form_name input_field" placeholder="Your name" required="required" data-error="Name is required." name="name">

                                        <input type="email" id="contact_form_email" class="contact_form_email input_field" placeholder="Your email" required="required" data-error="Email is required." name="email">

                                        <input type="text" id="contact_form_phone" class="contact_form_phone input_field" placeholder="Your phone number" name="mobile">
                                    </div>
                                    <div class="contact_form_text">
                                        <textarea id="contact_form_message" class="text_field contact_form_message" name="message" rows="4" placeholder="Message" required="required" data-error="Please, write us a message."></textarea>
                                    </div>
                                    <div class="contact_form_button text-center pb-2">
                                        <button type="submit" class="btn  btn-dark" name="contacts">Send Message</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-5 shadow border-2 border-info">
                    <div class="mapouter">
                        <div class="gmap_canvas"><iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=Nawar Properties Ltd&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://connectionsgame.org/">Connections NYT</a></div>
                        <style>
                            .mapouter {
                                position: relative;
                                text-align: right;
                                width: 1300px;
                                height: 500px;
                            }

                            .gmap_canvas {
                                overflow: hidden;
                                background: none !important;
                                width: 1300px;
                                height: 500px;
                            }

                            .gmap_iframe {
                                width: 1300px !important;
                                height: 500px !important;
                            }
                        </style>
                    </div>
                </div>

            </div>

        </section>
        


        <?php 
     
     include_once("footer.php");
   ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
<!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>