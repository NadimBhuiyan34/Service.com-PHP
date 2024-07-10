<?php
session_start(); // Start the session
include('config.php');
 
// request submit
if (isset($_POST['requestBtn'])) {

    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $message = $_POST['message'];

    // Enable error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Check if there's an existing pending request
        $checkSql = "SELECT * FROM `service_requests` WHERE user_id = '$user_id' AND servicer_id = '$servicer_id' AND status = 'pending'";
        $result = mysqli_query($connection, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            $message = "Request Already Submitted";
            header("Location: servicer_profile.php?error=" . urlencode($message) . "&id=" . urlencode($servicer_id));
            exit;
        } else {
            $confirmationCode = mt_rand(100000, 999999);
            $servicerQuery = "INSERT INTO `service_requests`(`user_id`, `servicer_id`, `message`, `confirmation_code`, `status`) VALUES ('$user_id', '$servicer_id', '$message', '$confirmationCode', 'pending')";
            $request = mysqli_query($connection, $servicerQuery);

            if ($request) {
                $message = "Request Submitted Successfully";
                header("Location: servicer_profile.php?message=" . urlencode($message) . "&id=" . urlencode($servicer_id));
                exit;
            } else {
                throw new Exception("Error executing query: " . mysqli_error($connection));
            }
        }
    } catch (Exception $e) {
        $message = "Something is wrong: " . $e->getMessage();
        header("Location: servicer_profile.php?error=" . urlencode($message) . "&id=" . urlencode($servicer_id));
        exit;
    }
}
//  review btn
if (isset($_POST['reviewBtn'])) {

    $user_id = $_POST['user_id'];
    $servicer_id = $_POST['servicer_id'];
    $star = $_POST['star'];
    $message = $_POST['message'];

    $checkSql = "SELECT `id` FROM `reviews` WHERE user_id = $user_id AND servicer_id = $servicer_id";
    $result = mysqli_query($connection, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        $updateReview = "UPDATE `reviews` SET `message`='$message',`rating_point`='$star' WHERE user_id = $user_id AND servicer_id = $servicer_id";

        if (mysqli_query($connection, $updateReview)) {
            $message = "Review Submitted Successfully";
            header("Location: servicer_profile.php?message=" . urlencode($message) . "&id=" . urldecode($servicer_id));
            exit;
        }
    } else {

        $servicerQuery = "INSERT INTO `reviews`(`user_id`, `service_id`, `servicer_id`, `message`, `rating_point`) VALUES ('$user_id','8','$servicer_id','$message','$star')";
        $request = mysqli_query($connection, $servicerQuery);

        if ($request) {
            $message = "Review Submitted Successfully";
            header("Location: servicer_profile.php?message=" . urlencode($message) . "&id=" . urldecode($servicer_id));
            exit;
        } else {
            $message = "Something is wrong";
            header("Location: servicer_profile.php?message=" . urlencode($message) . "&id=" . urlencode($servicer_id));
            exit;
        }
    }
}

// servicer Details
$user_id = $_GET['id'];
$servicerQuery = "
SELECT 
    users.id AS user_id, 
    users.name, 
    users.mobile, 
    users.created_at, 
    servicer_profiles.experience,
    servicer_profiles.address, 
    servicer_profiles.area, 
    servicer_profiles.category_id, 
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
WHERE 
    users.id = $user_id
GROUP BY 
    users.id, 
    users.name, 
    users.mobile, 
    users.created_at, 
    servicer_profiles.experience,
    servicer_profiles.address, 
    servicer_profiles.area, 
    servicer_profiles.category_id, 
    servicer_profiles.biography, 
    servicer_profiles.profile_image,
    categories.title
ORDER BY 
    average_rating DESC";
$servicers = mysqli_query($connection, $servicerQuery);
$servicer = mysqli_fetch_assoc($servicers);



/// ...
$category_id = $servicer['category_id'];
$relatedQuery = "
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
WHERE 
    users.status = 'Active' AND servicer_profiles.category_id = $category_id
GROUP BY 
    users.id, 
    users.name, 
    users.mobile, 
    users.created_at, 
    servicer_profiles.experience,
    servicer_profiles.address, 
    servicer_profiles.biography, 
    servicer_profiles.profile_image,
    categories.title
ORDER BY 
    average_rating DESC
LIMIT 12";

$relatedServicers = mysqli_query($connection,  $relatedQuery);




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

    <link rel="stylesheet" href="frontend/includes/css/servicer_profile.css">
    <link rel="stylesheet" href="frontend/includes/css/card.css">
    <link rel="stylesheet" href="frontend/includes/css/review.css">

</head>

<body style="background-color: rgb(224, 241, 253);">
    <!-- header -->

    <?php

    include_once("header.php");
    ?>
    <!-- alert message -->
    <?php include_once "frontend/includes/layouts/message/alert.php" ?>
    <!-- end alert message -->
    <section style="margin-top: 80px;">
        <!-- <img class="contactus d-none d-lg-block d-xl-block" src="https://images6.fanpop.com/image/photos/39600000/Sparkle-Stars-Profile-Banner-smile19-39654242-946-250.jpg" alt="" style="height:400px;width:100%"> -->

        <div class="d-xl-none d-lg-none mt-5 border-2 border-danger" style="background-color: hsl(23, 96%, 82%);">
            <h2 class="text-center p-2 text-white">Servicer Profile</h2>
        </div>
        <!-- end slider -->
    </section>

    <section class="section about-section shadow-2" id="about">
        <div class="container rounded-5 p-3" style="background-color: #fffffff5;">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6 d-block d-md-none d-lg-none">
                    <div class="about-avatar">
                        <img src="frontend/image//profile/<?php echo $servicer['profile_image'] ?>" title="" alt="" class="border border-4 border-black p-3 " style="width:300px;height:300px">
                        <br>
                        <div class="mt-3 ">
                            <button class="btn btn-success px-5  fs-5"><i class="fa-regular fa-star"></i> Reviews</button>

                            <?php
                            if (!isset($_SESSION['role']) || ($_SESSION['role'] == 'user' && isset($_SESSION['role']))) {
                            ?>
                                <a href="<?php echo isset($_SESSION['user_id']) ? '#request' . $servicer['user_id'] : 'login.php'; ?>" class="btn btn-primary px-3  fs-5 btn-rounded waves-effect w-md waves-light " <?php echo isset($_SESSION['user_id']) ? 'data-bs-toggle="modal"' : ''; ?>>
                                    Request Now
                                </a>
                            <?php
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-text go-to">
                        <h3 class="dark-color"><?php echo $servicer['name'] ?></h3>
                        <h6 class="text-primary lead"><?php echo $servicer['category_title'] ?> Servicer</h6>

                        <div class="row  mx-auto">
                            <div class="col-md-6 col-6">
                                <div class="media">
                                    <label>Name</label>
                                    <p><?php echo $servicer['name'] ?></p>
                                </div>
                                <div class="media">
                                    <label>Mobile</label>
                                    <p><?php echo $servicer['mobile'] ?></p>
                                </div>
                                <div class="media">
                                    <label>Area</label>
                                    <p><?php echo $servicer['area'] ?></p>
                                </div>
                                <div class="media">
                                    <label>Address</label>
                                    <p><?php echo $servicer['address'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="media">
                                    <label>Experience</label>
                                    <p><?php echo $servicer['experience'] ?></p>
                                </div>
                                <div class="media">
                                    <label>Category</label>
                                    <p><?php echo $servicer['category_title'] ?></p>
                                </div>
                                <div class="media">
                                    <label>Rating</label>
                                    <p><?php echo isset($servicer['average_rating']) ? $servicer['average_rating'] : 0; ?>/5</p>

                                </div>
                                <div class="media">
                                    <label>Joined Date</label>
                                    <p><?php echo $servicer['created_at'] ?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-md-block d-lg-block">
                    <div class="about-avatar">
                        <img src="frontend/image//profile/<?php echo $servicer['profile_image'] ?>" title="" alt="" class="border border-4 border-black p-3" style="width:300px;height:300px">
                        <br>
                        <div class="mt-3">

                            <?php
                            if (!isset($_SESSION['role']) || ($_SESSION['role'] == 'user' && isset($_SESSION['role']))) {
                            ?>


                                <a href="<?php echo isset($_SESSION['user_id']) ? '#exampleModal' . $servicer['user_id'] : 'login.php'; ?>" class="btn btn-primary btn-sm text-center " <?php echo isset($_SESSION['user_id']) ? 'data-bs-toggle="modal"' : ''; ?>>
                                    Review
                                </a>

                                <a href="<?php echo isset($_SESSION['user_id']) ? '#request' . $servicer['user_id'] : 'login.php'; ?>" class="btn btn-success btn-sm  " <?php echo isset($_SESSION['user_id']) ? 'data-bs-toggle="modal"' : ''; ?>>
                                    Request Now
                                </a>
                            <?php
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-center text-dark fw-bold">About Me</h3>
                    <hr>
                    <p style="text-align:justify">I <mark><?php echo $servicer['category_title'] ?> Servicer</mark> <?php echo $servicer['biography'] ?></p>
                </div>


            </div>
            <div class="counter bg-warning">
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
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="500" data-speed="500">500</h6>
                            <p class="m-0px font-w-600">Happy Clients</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="150" data-speed="150"><?php echo $pendingCount ?></h6>
                            <p class="m-0px font-w-600">Pending Work</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="850" data-speed="850"><?php echo $acceptedCount ?></h6>
                            <p class="m-0px font-w-600">Ongoing Work</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="190" data-speed="190"><?php echo $completedCount ?></h6>
                            <p class="m-0px font-w-600">Conpleted Work</p>
                        </div>
                    </div>
                </div>
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
                        <form action="servicer_profile.php" method="POST">
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

        <!-- modal review -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal<?php echo $servicer['user_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel">Request for Serivce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="servicer_profile.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                            <input type="hidden" name="servicer_id" value="<?php echo $servicer['user_id'] ?>">

                            <select class="form-select" aria-label="Default select example" name="star">
                                <option selected>Open this select star</option>
                                <option value="1">One Star</option>
                                <option value="2">Two Star</option>
                                <option value="3">Three Star</option>
                                <option value="4">Four Star</option>
                                <option value="5">Five Star</option>
                            </select>
                            <div class="form-group mx-auto">
                                <label for="exampleTextarea " class="fw-bold fs-4 mb-3 text-center">Message</label>
                                <textarea class="form-control border-3 border-warning" id="exampleTextarea" rows="3" name="message"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" name="reviewBtn">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of modal -->
        <!-- Related Servicer -->


        <!-- review -->


        <div class="container  mb-100 w-100 mt-3">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h1>User Review</h1>
                        </div>

                        <div class="comment-widgets m-b-20" style="max-height: 400px; overflow-y: auto;">
                            <?php
                            $servicer_id = $_GET['id'];
                            $reviewQuery = "SELECT 
                        r.`id`,
                        r.`message`,
                        r.`rating_point`,
                        r.`created_at`,
                        u.`name`,
                        up.`profile_image`
            
                        FROM 
                            `reviews` r
                        JOIN
                            `users` u ON r.`user_id` = u.`id`
                        JOIN
                            `user_profiles` up ON r.`user_id` = up.`user_id`
                        WHERE 
                            r.`servicer_id` =  $servicer_id;
                        ";
                            $reviews = mysqli_query($connection, $reviewQuery);
                            while ($review = mysqli_fetch_assoc($reviews)) {
                            ?>
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="frontend/image//profile/<?php echo $review['profile_image'] ?>" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5><?php echo $review['name']; ?></h5>
                                        <div class="comment-footer">
                                            <?php
                                            if (!function_exists('formatDate')) {
                                                function formatDate($timestamp)
                                                {
                                                    // Convert the timestamp to a DateTime object
                                                    $date = new DateTime($timestamp);

                                                    // Format the date as "d F Y" (12 December 2023)
                                                    $formattedDate = $date->format('d F Y');

                                                    // Calculate the time difference
                                                    $now = new DateTime();
                                                    $interval = $now->diff($date);

                                                    // Format and append the time difference
                                                    if ($interval->y > 0) {
                                                        $formattedDate .= ' ' . $interval->format('%y years ago');
                                                    } elseif ($interval->m > 0) {
                                                        $formattedDate .= ' ' . $interval->format('%m months ago');
                                                    } elseif ($interval->d > 0) {
                                                        $formattedDate .= ' ' . $interval->format('%d days ago');
                                                    } elseif ($interval->h > 0) {
                                                        $formattedDate .= ' ' . $interval->format('%h hours ago');
                                                    } elseif ($interval->i > 0) {
                                                        $formattedDate .= ' ' . $interval->format('%i minutes ago');
                                                    } else {
                                                        $formattedDate .= ' just now';
                                                    }

                                                    return $formattedDate;
                                                }
                                            }

                                            // Rest of your code...
                                            ?>


                                        </div>
                                        <div class="comment-footer">
                                            <span class="date"><?php echo formatDate($review['created_at']); ?></span>
                                            <div class="rating">
                                                <?php
                                                $rating = $review['rating_point'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        // Filled star
                                                        echo '<i class="fas fa-star text-warning"></i>';
                                                    } else {
                                                        // Unfilled star
                                                        echo '<i class="far fa-star text-warning"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <p class="m-b-5 m-t-10"><?php echo $review['message']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <section class="container mt-5">
            <h3>Related Servicer</h3>
            <hr>


            <div class="container mt-5">


                <!-- end row -->
                <div class="row">
                    <?php
                    while ($servicer = mysqli_fetch_assoc($relatedServicers)) {
                    ?>
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6 shadow-2">
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



                    <?php } ?>



                </div>







            </div>
        </section>

    </section>






    <?php include_once("footer.php"); ?>


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</body>

</html>