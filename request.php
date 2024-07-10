<?php
session_start(); // Start the session
include('config.php');
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$status = $_GET['status'];
$data = array();
// cancel request
if (isset($_POST['cancelRequest'])) {
    $id = $_POST['request_id'];
    $type = $_POST['type'];

    $cancelQuery = "UPDATE `service_requests` SET `status`='cancel', `updated_at` = NOW() WHERE id = $id";
   
    if (mysqli_query($connection, $cancelQuery)) {
        $message = "Request Successfully Cancelled";
        header("Location: request.php?message=" . urlencode($message) . "&status=" . urlencode($type));
        exit;
    }
}
// accept request
if (isset($_POST['acceptRequest'])) {
    $id = $_POST['request_id'];
    $type = $_POST['type'];

    $cancelQuery = "UPDATE `service_requests` SET `status`='accepted', `updated_at` = NOW() WHERE id = $id";

    if (mysqli_query($connection, $cancelQuery)) {
        $message = "Request Successfully Accepted";
        header("Location: request.php?message=" . urlencode($message) . "&status=" . urlencode($type));
        exit;
    }
}
// completed request
if (isset($_POST['completedRequest'])) {
    $id = $_POST['request_id'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $requestQuery = "SELECT `confirmation_code` FROM `service_requests` WHERE id = $id";
    $result = mysqli_query($connection, $requestQuery);
    $row = mysqli_fetch_assoc($result);

    if($row['confirmation_code'] === $code)
    {
        $cancelQuery = "UPDATE `service_requests` SET `status`='completed', `completed_at` = NOW() WHERE id = $id";

        if (mysqli_query($connection, $cancelQuery)) {
            $message = "Work Successfully Done";
            header("Location: request.php?message=" . urlencode($message) . "&status=" . urlencode($type));
            exit;
        }
    }
    else
    {
        $message = "Confrimation code does not match";
        header("Location: request.php?message=" . urlencode($message) . "&status=" . urlencode($type));
        exit;
    }


   
}
if ($role == 'user') {
    $userQuery = "
    SELECT 
        users.name,
        users.id AS user_id,
        users.mobile,
        servicer_profiles.address,
        servicer_profiles.experience,
        servicer_profiles.biography,
        servicer_profiles.profile_image,
        categories.title,
        COALESCE(AVG(reviews.rating_point), 0) AS average_rating,
        service_requests.id AS request_id,
        service_requests.status,
        service_requests.message,
        service_requests.confirmation_code,
        service_requests.created_at,
        service_requests.updated_at,
        service_requests.completed_at
    FROM service_requests
    JOIN servicer_profiles ON service_requests.servicer_id = servicer_profiles.user_id
    JOIN users ON servicer_profiles.user_id = users.id
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id
    JOIN categories ON servicer_profiles.category_id = categories.id
    WHERE service_requests.user_id = '$user_id'
    AND service_requests.status = '$status'
       
     GROUP BY
        users.id,
        users.name,
        users.mobile,
        servicer_profiles.address,
        servicer_profiles.experience,
        servicer_profiles.biography,
        servicer_profiles.profile_image,
        categories.title,
        service_requests.id,
        service_requests.status,
        service_requests.message,
        service_requests.confirmation_code,
        service_requests.created_at,
        service_requests.updated_at,
        service_requests.completed_at
    ORDER BY service_requests.created_at ASC; 
";
} else {

    $userQuery = "
    SELECT 
        users.name,
        users.id AS user_id,
        users.mobile,
        user_profiles.address,
        user_profiles.profile_image,
        service_requests.id AS request_id,
        service_requests.status,
        service_requests.message,
        service_requests.created_at,
        service_requests.updated_at,
        service_requests.completed_at
    FROM service_requests
    JOIN user_profiles ON service_requests.user_id = user_profiles.user_id
    JOIN users ON user_profiles.user_id = users.id
    WHERE service_requests.servicer_id = '$user_id'
    AND service_requests.status = '$status' ORDER BY service_requests.created_at DESC;
";
}
$requests = mysqli_query($connection,  $userQuery);




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
    <title>Service Request</title>


    <link rel="icon" href="" type="image/x-icon">
    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="frontend/includes/css/footer.css">
    <link rel="stylesheet" href="frontend/includes/css/card.css">

</head>

<body style="background-color: rgb(224, 241, 253);">
    <!-- header -->

    <?php

    include_once("header.php");
    ?>
    <!-- alert message -->
    <?php include_once "frontend/includes/layouts/message/alert.php" ?>
    <!-- end alert message -->
    <section style="margin-top: 150px;">
        <!-- <img class="contactus d-none d-lg-block d-xl-block" src="https://www.antraajaal.in/images/background/services2.jpg" alt="" style="height:400px;width:100%"> -->

        <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 77%, 48%);">
            <h2 class="text-center p-2 text-white">Service Request</h2>
        </div>
        <!-- end slider -->
    </section>



    <section>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="content mt-5 mb-5">
            <div class="container">
                <!-- end row -->
                <div class="row">
                    <?php
                    while ($request = mysqli_fetch_assoc($requests)) {
                    ?>
                        <div class="col-lg-6 col-md-12 col-12 col-sm-12 mb-4 text-white">


                            <?php if ($_SESSION['role'] == 'servicer') { ?>
                                <div class="card" style="height: 250px;">
                                    <div class="">

                                        <div class="px-3 d-flex justify-content-between py-1 text-white" style="background-color: rgb(3, 27, 89);">
                                            <div>
                                                <h4><?php echo $request['name'] ?></h4>
                                                <span class="fw-bold"><i class="fa-solid fa-mobile-retro"></i> <?php echo $request['mobile'] ?></span> <br>
                                                <span><i class="fa-solid fa-location-dot"></i> <?php echo $request['address'] ?></span> <br>
                                                <span class=""><i class="fa-solid fa-calendar-days"></i> Requested Date: <?php
                                                                                                                            // Assuming $request['created_at'] contains a valid timestamp or date string
                                                                                                                            $timestamp = strtotime($request['created_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span> <br>
                                                <span class="<?php echo ($request['status'] == 'accepted' || $request['status'] == 'cancel') ? 'd-block' : 'd-none'; ?>"><i class="fa-solid fa-calendar <?php echo ($request['status'] == 'cancel') ? 'text-danger' : 'text-primary'; ?>"></i> <?php echo ($request['status'] == 'cancel') ? 'Cancel' : 'Accepted'; ?> Date: <?php
                                                                                                                            // Assuming $request['created_at'] contains a valid timestamp or date string
                                                                                                                            $timestamp = strtotime($request['updated_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span> <br>
                                                <span class="<?php echo ($request['status'] == 'completed') ? 'd-block' : 'd-none'; ?>"><i class="fa-solid fa-calendar-check text-success"></i> Completed Date: <?php
                                                                                                                            // Assuming $request['created_at'] contains a valid timestamp or date string
                                                                                                                            $timestamp = strtotime($request['completed_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span> <br>

                                            </div>

                                            <div>
                                                <img src="frontend/image/profile/<?php echo $request['profile_image'] ?>" alt="" style="width:100px;height:100px;float:right">
                                            </div>


                                        </div>


                                    </div>

                                    <p class="px-3 pt-2" style="text-align: justify;"><?php echo $request['message'] ?></p>

                                </div>
                                <?php if ($request['status'] != 'completed' && $request['status'] != 'cancel') { ?>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <form action="request.php" method="POST">
                                            <input type="hidden" name="request_id" value="<?php echo $request['request_id'] ?>">
                                            <input type="hidden" name="type" value="<?php echo $_GET['status'] ?>">
                                            <button class="btn btn-sm btn-danger" type="submit" name="cancelRequest">
                                                Click here for Cancel
                                            </button>

                                        </form>

                                        <form action="request.php" method="POST" class="<?php echo ($request['status'] == 'accepted') ? 'd-none' : 'd-block'; ?>">
                                            <input type="hidden" name="request_id" value="<?php echo $request['request_id'] ?>">
                                            <input type="hidden" name="type" value="<?php echo $_GET['status'] ?>">
                                            <button class="btn btn-sm btn-success" type="submit" name="acceptRequest">
                                                Click here for Accepted
                                            </button>
                                        </form>
                                        <!--  -->
                                        <button type="button" class="btn btn-primary btn-sm <?php echo ($request['status'] == 'accepted') ? 'd-block' : 'd-none'; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Click here for Completed
                                        </button>


                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation Code</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                       <p class="text-danger fw-bold">Please collect six digit confirmation code from client.</p>
                                                        <form class="row g-3" action="request.php" method="POST">
                                                        <input type="hidden" name="request_id" value="<?php echo $request['request_id'] ?>">
                                            <input type="hidden" name="type" value="<?php echo $_GET['status'] ?>">
                                                            <div class="col-12">
                                                                <label for="code" class="form-label fs-4 text-center">Enter Code</label>
                                                                <input type="text" class="form-control border-2 border-warning" id="code" name="code">
                                                            </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm" name="completedRequest">Submit</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <!-- user view -->
                                <div class="card rounded-3" style="height: 300px;">
                                    <div class="">

                                        <div class="px-3 d-flex justify-content-between py-1 rounded-3 " style="background-color: rgba(5, 40, 40, 0.815);">
                                            <div class="text-white">
                                                <h4><?php echo $request['name'] ?> (<?php echo $request['title'] ?>)</h4>
                                                <span></span>
                                                <span class="fw-bold"><i class="fa-solid fa-mobile-retro"></i> <?php echo $request['mobile'] ?></span> <br>
                                                <span><i class="fa-solid fa-location-dot"></i> <?php echo $request['address'] ?></span> <br>
                                                <span><i class="fas fa-star"></i> Rating: <?php echo $request['average_rating'] ?>/5</span> <br>
                                                <span class=""><i class="fa-solid fa-calendar-days"></i> Requested Date: <?php
                                                                                                                            // Assuming $request['created_at'] contains a valid timestamp or date string
                                                                                                                            $timestamp = strtotime($request['created_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span> <br>
                                                <span class="<?php echo ($request['status'] == 'accepted' || $request['status'] == 'cancel' || $request['status'] == 'completed') ? 'd-block' : 'd-none'; ?>"><i class="fa-solid fa-calendar <?php echo ($request['status'] == 'cancel') ? 'text-danger' : 'text-primary'; ?>"></i> <?php echo ($request['status'] == 'cancel') ? 'Cancel' : 'Accepted'; ?> Date: <?php
                                                                                                                         
                                                                                                                            $timestamp = strtotime($request['updated_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span> 
                                                <span class="<?php echo ($request['status'] == 'completed') ? 'd-block' : 'd-none'; ?>"><i class="fa-solid fa-calendar-check text-success"></i> Completed Date: <?php
                                                                                                                            // Assuming $request['created_at'] contains a valid timestamp or date string
                                                                                                                            $timestamp = strtotime($request['completed_at']);
                                                                                                                            $formattedDate = date('d-F-Y', $timestamp);
                                                                                                                            echo $formattedDate;
                                                                                                                            ?></span>
                          <span><i class="fa-solid fa-key"></i> ConfirmationCode: <?php echo $request['confirmation_code'] ?></span> <br>                                                                                                   



                                            </div>

                                            <div>
                                                <img src="frontend/image/profile/<?php echo $request['profile_image'] ?>" alt="" style="width:100px;height:100px;float:right">
                                               

                                            </div>


                                        </div>


                                    </div>

                                    <p class="px-3 pt-2" style="text-align: justify;"><?php echo $request['message'] ?></p>


                                </div>
                                <?php if ($request['status'] != 'completed' && $request['status'] != 'cancel') { ?>
                                    <form action="request.php" method="POST">
                                            <input type="hidden" name="request_id" value="<?php echo $request['request_id'] ?>">
                                            <input type="hidden" name="type" value="<?php echo $_GET['status'] ?>">
                                            <button class="btn btn-sm btn-danger float-end" type="submit" name="cancelRequest">
                                                Click here for Cancel
                                            </button>

                                        </form>

                                <?php } ?>

                            <?php } ?>

                        </div>








                    <?php } ?>



                </div>







            </div>
            <!-- container -->
        </div>
    </section>





    <?php

    include_once("footer.php");
    ?>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
    <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>