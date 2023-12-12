<?php
session_start(); // Start the session
include('config.php');

  // Your database query here
  // Your pagination query here, using LIMIT and OFFSET
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
      WHERE 
          users.status = 'Active'
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
    $servicers = mysqli_query($connection, $servicerQuery);

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
  <link rel="stylesheet" href="frontend/includes/css/card.css">
</head>

<body style="background-color: rgb(224, 241, 253);">
  <!-- header -->

  <?php 
     
     include_once("header.php");
   ?>


  <div class="" style="margin-top:150px;">
   
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://www.precisionairandplumbing.com/wp-content/uploads/2023/10/bg-ac-hero.jpg" class="d-block" alt="..." style="width:100%;height:650px">
      <div class="carousel-caption d-none d-md-block">
        <div class="rounded-5 text-white">
        <h3 class="text-white fw-bold ">AC Repair Services for a Cool and Comfortable Home</h3>
        <p class="text-white fs-5 fw  rounded-3 p-2">
          
          Is your air conditioner acting up? Don't let the heat take away your comfort! Our skilled AC repair services are here to ensure your home remains cool and cozy, even on the hottest days..</p>
          </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://5.imimg.com/data5/SELLER/Default/2022/5/BG/ZA/FV/149966957/whatsapp-image-2022-05-03-at-8-39-00-pm.jpeg" class="d-block" alt="..." style="width:100%;height:650px">
      <div class="carousel-caption d-none d-md-block" style="background-color: rgba(255, 255, 93, 0.602);">
        <h3 class="text-dark fw-bold">Professional Painting Services for a Stunning Home Transformation</h3>
        <p class="text-dark fs-5 p-3">Elevate the aesthetics of your living space with our expert painting services. At [Your Painting Company], we specialize in delivering top-notch painting solutions that breathe new life into your home.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://concordkolkata.com/home-appliances/wp-content/uploads/sites/10/2020/06/Home-810x275.jpg" class="d-block" alt="..." style="width:100%;height:650px">
      <div class="carousel-caption d-none d-md-block">
        
<h3 class="text-white fw-bold">Reliable Appliance Repair Services for a Hassle-Free Home</h3>
<p class="text-white fs-5 p-3">When your household appliances stop working, it can disrupt your daily routine. That's where we come in – your trusted appliance repair service provider. At [Your Appliance Repair Company], we specialize in prompt and effective solutions to get your appliances back up and running in no time.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>






    <div class="row">
      <div class=" text-center w-100">
        <div class="bg-image h-100">
          <h1 class="text-dark" style="padding-top: 50px;"><strong>Find Services On-the-Go</strong></h1>
          <h4 class="text-danger">Connect with Servicers at Your Own Pace.</h4>

          <div class="row justify-content-center pt-2" style="padding-bottom:100px;">
            <div class="col-md-4 col-10">
              <?php
              if (!isset($_SESSION['user_id'])) {
              ?>
                <div class="d-lg-none d-flex gap-2">
                  <div class="mx-auto d-flex gap-2">
                  <div class="">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Register <i class="fa-solid fa-user-plus"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Survicer</a></li>
                      <li><a class="dropdown-item fw-bold" href="#">Users</a></li>
                    </ul>
                  </div>
                    <div class="text-center">
                    <button class="btn btn-success btn-sm mb-2" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login <i class="fa-solid fa-right-to-bracket"></i></button>
                    </div>
                  </div>
                 
                </div>
              <?php } ?>
              <div class="input-group mb-3 input-group-lg">

                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-danger" type="button" id="button-addon2"><i class="fas fa-search"></i></button>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
 

  <div class="container">
    <div class="row mt-3">
    <?php 
                     $query = "SELECT * FROM categories WHERE status = 'Active' ORDER BY id DESC";
                     $categories = mysqli_query($connection, $query);
                     while ($category = mysqli_fetch_assoc($categories)) {
                        ?>
       
        <div class="col-4 col-md-2 text-center border bg-white  rounded-3">
        <div class="p-2">
         <a href="servicer.php?type=<?php echo $category['id'] ?>">
       <img src="admin/public/category/<?php echo $category['banner_image']; ?>" alt="" style="width:100px;height:100px">


       </a>
       <span class="d-block d-md-inline fw-bold d-md-block"><?php echo $category['title'] ?></span>
          
        </div>
      </div>
       
      <?php
                     }
      ?>
    </div>
    <!-- servicer container -->
    <div class="container mt-5">
      <h1>Servicer</h1>
      <hr>
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
                






            </div>
    <!-- first content -->
    <div class="mt-5">
      <h3 class="mb-3">For Your Home</h3>
      <div class="d-flex overflow-auto justify-content-between gap-1">
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1583777507_gasstove/burnerrepair_270x180.webp" alt="" class="img-fluid">

          <h5>Gas Stove/Burner Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1619428672_plumbingsanitaryservices_270x180.webp" alt="" class="img-fluid">

          <h5>Plumbing & Sanitary Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1612862065_paintingservices_270x180.webp" alt="" class="img-fluid">

          <h5>Painting Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1617855940_homecleaning_270x180.webp" alt="" class="img-fluid">

          <h5>Home Cleaning</h5>
        </div>
      </div>
    </div>
    <!-- Second Content -->
    <div class="" style="margin-top: 150px;">
      <h3 class="mb-3">Trending</h3>
      <div class="d-flex overflow-auto justify-content-between gap-1">
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1583777507_gasstove/burnerrepair_270x180.webp" alt="" class="img-fluid">

          <h5>Gas Stove/Burner Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1619428672_plumbingsanitaryservices_270x180.webp" alt="" class="img-fluid">

          <h5>Plumbing & Sanitary Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1612862065_paintingservices_270x180.webp" alt="" class="img-fluid">

          <h5>Painting Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1617855940_homecleaning_270x180.webp" alt="" class="img-fluid">

          <h5>Home Cleaning</h5>
        </div>
      </div>
    </div>
    <!-- Third Content -->
    <div class="" style="margin-top: 150px;">
      <h3 class="mb-3">Reconmended</h3>
      <div class="d-flex overflow-auto justify-content-between gap-1">
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1583777507_gasstove/burnerrepair_270x180.webp" alt="" class="img-fluid">

          <h5>Gas Stove/Burner Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1619428672_plumbingsanitaryservices_270x180.webp" alt="" class="img-fluid">

          <h5>Plumbing & Sanitary Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1612862065_paintingservices_270x180.webp" alt="" class="img-fluid">

          <h5>Painting Services</h5>
        </div>
        <div class="col-6 col-md-4 col-xl-4">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/thumbs/1617855940_homecleaning_270x180.webp" alt="" class="img-fluid">

          <h5>Home Cleaning</h5>
        </div>
      </div>
    </div>

  </div>



  <?php 
     
     include_once("footer.php");
   ?>
 
  <!-- js -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
  <!-- Vendor JS Files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>