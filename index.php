<?php
session_start(); // Start the session

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

  <?php include_once("includes/layouts/header.php") ?>


  <div class="" style="margin-top:70px;">
    <div class="row">
      <div class=" text-center w-100">
        <div class="bg-image h-100" style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230616/pngtree-digital-delivery-3d-smartphone-rendering-with-hand-holding-online-package-and-image_3614126.png');">
          <h1 class="text-white" style="padding-top: 50px;"><strong>Your Personal Assistant</strong></h1>
          <h4 class="text-white">One-stop solution for your services. Order any service, anytime.</h4>

          <div class="row justify-content-center pt-2" style="padding-bottom:100px;">
            <div class="col-md-4 col-10">
            <?php
          if (!isset($_SESSION['user_id'])) {
          ?>
              <button class="btn btn-primary btn-sm mb-2" type="button">Register <i class="fa-solid fa-user-plus"></i>

              </button>
              <button class="btn btn-success btn-sm mb-2" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login <i class="fa-solid fa-right-to-bracket"></i></button>
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
      <div class="col-4 col-md-2 text-center border">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/icons_png/1583681524_tiwnn_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Appliance Repair</span>
        </div>
      </div>
      <div class="col-4 col-md-2 text-center border">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/v4_uploads/category_icons/226/default_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Painting & Renovation</span>
        </div>
      </div>
      <div class="col-4 text-center border col-md-2">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/v4_uploads/category_icons/236/default_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Trips & Travels</span>
        </div>
      </div>
      <div class="col-4 text-center border col-md-2">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/icons_png/1583681093_tiwnn_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Shifting</span>
        </div>
      </div>
      <div class="col-4 text-center border col-md-2">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/icons_png/1583681093_tiwnn_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Shifting</span>
        </div>
      </div>
      <div class="col-4 text-center border col-md-2">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/icons_png/1583681093_tiwnn_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Shifting</span>
        </div>
      </div>
      <div class="col-4 text-center border col-md-2">
        <div class="p-2">
          <img src="https://s3.ap-south-1.amazonaws.com/cdn-shebaxyz/images/categories_images/icons_png/1583681093_tiwnn_52x52.webp" alt="">
          <span class="d-block d-md-inline fw-bold d-md-block">Shifting</span>
        </div>
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





  <!-- js -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/496c26838e.js" crossorigin="anonymous"></script>
  <!-- Vendor JS Files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>