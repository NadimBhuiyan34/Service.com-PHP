<?php
session_start(); // Start the session
include('config.php');

// request submit
if (isset($_POST['requestBtn'])) {

    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $message = $_POST['message'];

    $checkSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id ' AND servicer_id = '$servicer_id' AND status = 'pending'";

    $result = mysqli_query($connection, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        $message = "Request Allready Submitted";
        header("Location: servicer.php?message=" . urlencode($message). "&type=" . urlencode('All'));
        exit;
    } else {
        $confirmationCode = mt_rand(100000, 999999);
        $servicerQuery = "INSERT INTO `service_requests`(`user_id`, `servicer_id`, `message`, `confirmation_code`, `status`) VALUES ('$user_id','$servicer_id','$message','$confirmationCode','pending')";
        $request = mysqli_query($connection, $servicerQuery);

        if ($request) {
            $message = "Request Submitted Successfully";
            header("Location: servicer.php?message=" . urlencode($message). "&type=" . urlencode('All'));
            exit;
        } else {
            $message = "Something is wrong";
            header("Location: servicer.php?message=" . urlencode($message). "&type=" . urlencode('All'));
            exit;
        }
    }
}
include('servicer_code.php');

// request sent

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
    <title>Servicer</title>


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
    <section>
        <img class="contactus d-none d-lg-block d-xl-block" src="https://www.antraajaal.in/images/background/services2.jpg" alt="" style="height:400px;width:100%">

        <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 77%, 48%);">
            <h2 class="text-center p-2 text-white">All Servicer</h2>
        </div>
        <!-- end slider -->
    </section>

    <section class="container mt-5 mx-auto">
        <form action="servicer.php" method="POST" class="mx-auto">

            <div class="d-flex <?php echo isset($_POST['search']) ? 'justify-content-center' : 'justify-content-right'; ?>  gap-4 flex-column flex-xl-row flex-md-row flex-lg-row  p-3 rounded-3 pt-2 shadow-3 mx-auto" style="background-color: rgb(9, 1, 1);;">
                <div class="text-center mt-3 <?php echo isset($_POST['search']) ? 'd-none' : ''; ?> ">
                    <h3 class="text-white"><i class="fa-solid fa-users-gear"></i> Find <span class=""><?php echo $type_text ?></span> Servicer</h3>
                </div>

                
                <div>
                    <label for="" class="text-center fw-bold text-white pb-2">Area</label>
                    <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to area..." name="area" value="<?php echo (isset($_POST['area'])) ? htmlspecialchars($_POST['area']) : ''; ?>">

                    <datalist id="datalistOptions">
                        <option value="Tejgaon">Tejgaon</option>
                        <option value="Dhanmondi">Dhanmondi</option>
                        <option value="Banani">Banani</option>
                        <option value="Gulshan">Gulshan</option>
                        <option value="Baridhara">Baridhara</option>
                        <option value="Khilgaon">Khilgaon</option>
                        <option value="Mirpur">Mirpur</option>
                        <option value="Uttara">Uttara</option>
                        <option value="Banasree">Banasree</option>
                        <option value="Aftabnagar">Aftabnagar</option>
                    </datalist>
                </div>
                <div>
                    <label for="" class="text-center fw-bold text-white pb-2">Category</label>
                    <input class="form-control" list="datalistOptionscategory" id="exampleDataList" placeholder="Type to category..." name="category" value="<?php echo (isset($_POST['category'])) ? htmlspecialchars($_POST['category']) : ''; ?>">
                    <datalist id="datalistOptionscategory">

                        <?php
                        $query = "SELECT id, title FROM categories WHERE status = 'Active' ORDER BY id DESC;
                                                    ";
                        $categories = mysqli_query($connection, $query);
                        while ($category = mysqli_fetch_assoc($categories)) {
                        ?>
                            <option><?php echo $category['title'] ?></option>
                        <?php } ?>
                    </datalist>
                </div>
                <div class="my-auto text-center">
                    <button class="btn btn-warning mt-xl-4 mt-lg-4 mt-md-4" type="submit" name="search">Search</button>
                </div>
            </div>
        </form>

        </div>

    </section>


    <section>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="content mt-5">
            <div class="container">
                <!-- end row -->
                <div class="row">
                    <?php
                    while ($servicer = mysqli_fetch_assoc($servicers)) {
                    ?>
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                            <div class="text-center card-box rounded-3" style="height: 500px;">
                                <div class="member-card pt-2 pb-2">

                                    <div class="thumb-lg member-thumb mx-auto">
                                        <img src="frontend/image/profile/<?php echo $servicer['profile_image'] ?>" class="rounded-circle img-thumbnail" alt="profile-image">
                                    </div>

                                    <div class="">
                                        <h4><?php echo $servicer['name'] ?></h4>
                                        <p class="text-muted"> <span> </span><span class="fw-bold text-dark"><?php echo $servicer['category_title'] ?> Servicer</span></p>
                                    </div>

                                    <ul class="social-links list-inline rounded-2 p-2 bg-warning">
                                        <i class="fa-solid fa-mobile-retro"></i> <span class="fw-bold"><?php echo $servicer['mobile'] ?></span> <br>
                                        <i class="fa-solid fa-location-dot"></i> <?php echo $servicer['address'] ?> <br>
                                        <i class="fas fa-star"></i> Rating : <span><?php echo empty($servicer['average_rating']) ? '0' : $servicer['average_rating'] ?>/5</span>
                                    </ul>
                                    <?php
                                    if (!isset($_SESSION['role']) || ($_SESSION['role'] == 'user' && isset($_SESSION['role']))) {
                                    ?>
                                        <a href="<?php echo isset($_SESSION['user_id']) ? '#request' . $servicer['user_id'] : 'login.php'; ?>" class="btn btn-outline-warning text-dark mt-3 btn-rounded waves-effect w-md waves-light fw-bold" <?php echo isset($_SESSION['user_id']) ? 'data-bs-toggle="modal"' : ''; ?>>
                                            Request Now
                                        </a>
                                    <?php
                                    }
                                    ?>





                                    <?php
                                    $id = $servicer['user_id'];
                                    $query = "
                                     SELECT
                                        status,
                                        COUNT(*) AS status_count
                                     FROM
                                         service_requests
                                     WHERE
                                         servicer_id = '$id'
                                         AND status IN ('pending', 'accepted', 'completed')
                                     GROUP BY
                                         status;
                                 ";

                                    // Execute the query
                                    $result = mysqli_query($connection, $query);

                                    // Initialize counts for each status type
                                    $pendingCount = 0;
                                    $acceptedCount = 0;
                                    $completedCount = 0;
                                    // Fetch and update counts based on the status type
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        switch ($row['status']) {
                                            case 'pending':
                                                $pendingCount = $row['status_count'];
                                                break;
                                            case 'accepted':
                                                $acceptedCount = $row['status_count'];
                                                break;
                                            case 'completed':
                                                $completedCount = $row['status_count'];
                                                break;
                                        }
                                    }

                                    ?>
                                    <div class="mt-4">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mt-3">
                                                    <h4><?php echo  $pendingCount ?></h4>
                                                    <p class="mb-0 text-muted">Pending</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mt-3">
                                                    <h4><?php echo $acceptedCount ?></h4>
                                                    <p class="mb-0 text-muted">Accepted</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mt-3">
                                                    <h4> <?php echo $completedCount ?></h4>
                                                    <p class="mb-0 text-muted">Completed</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="servicer_profile.php?id=<?php echo $servicer['user_id'] ?>" class="btn btn-outline-primary btn-sm">Details</a>
                            </div>
                          
                        </div>


                        <!-- modal request -->
                        <!-- Modal -->

                        <div class="modal fade" id="request<?php echo $servicer['user_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title" id="exampleModalLabel">Request for Serivce</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="servicer.php" method="POST">
                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                            <input type="hidden" name="servicer_id" value="<?php echo $servicer['user_id'] ?>">
                                            <div class="form-group mx-auto">
                                                <label for="exampleTextarea " class="fw-bold fs-4 mb-3 text-center">Message</label>
                                                <textarea class="form-control border-3 border-warning" id="exampleTextarea" rows="3" name="message"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-sm" name="requestBtn">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- end of modal -->

                    <?php } ?>



                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        
                        if(isset($_GET['type']))
                        {
                            $type = $_GET['type'];
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                    <a class="page-link" href="?page=' . $i . '&type=' . $type . '">' . $i . '</a>
                </li>';
                            }
                        }
                        else
                        {
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                    <a class="page-link" href="?page=' . $i .'">' . $i . '</a>
                </li>';
                            }
                        }
                      
                        ?>
                    </ul>
                </nav>






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