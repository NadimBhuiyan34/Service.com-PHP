<?php
//  fetch category
require 'config.php';
session_start();
 
if(!isset( $_SESSION['user_id']))
{
  header("Location: index.php");
}
 
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin-Report</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once "include/layout/css.php" ?>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include_once "include/layout/topbar.php" ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include_once "include/layout/sidebar.php" ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

    <div class="pagetitle d-flex justify-content-between">
      <div class="mt-3">
        <h1>User Report</h1>

        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">User Report</li>
          </ol>
        </nav>
      </div>
      <div class="text-center p-2">
        <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:100px !important;height:75px !important" class="text-center">
      </div>

    </div><!-- End Page Title -->

<section class="section faq">
  <div class="row">
    <div class="col-lg-6">

      <div class="card basic">
        <div class="card-body">
          <h5 class="card-title">Today Report</h5>
          <?php
                $requestQuery = "SELECT sr.*, 
                u1.name AS user_name, 
                u2.name AS servicer_name
         FROM reports sr
         LEFT JOIN users u1 ON sr.user_id = u1.id
         LEFT JOIN users u2 ON sr.report_id = u2.id
         WHERE DATE(sr.created_at) = CURDATE()
         ORDER BY sr.created_at DESC
         LIMIT 6         
            ";
                $result = mysqli_query($connection, $requestQuery);
                $serialNumber = 1;
                while ($request = mysqli_fetch_assoc($result)) {
            ?>

          <div>
            <h6><?php echo $serialNumber++; ?>.  <a href="request.php" class="fw-bold text-dark"><?php echo $request['user_name'] ?></a> report to <span class="fw-bold text-dark"><?php echo $request['servicer_name'] ?></span></h6>
            <p><?php echo $request['report'] ?></p>
          </div>
          <?php } ?>
           

        </div>
      </div>

      <!-- F.A.Q Group 1 -->
     

    </div>

    <div class="col-lg-6">

      <!-- F.A.Q Group 2 -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">All report from user</h5>

          <div class="accordion accordion-flush" id="faq-group-2">
          <?php
                $requestQuery = "SELECT sr.*, 
                u1.name AS user_name, 
                u2.name AS servicer_name
         FROM reports sr
         LEFT JOIN users u1 ON sr.user_id = u1.id
         LEFT JOIN users u2 ON sr.report_id = u2.id
         ORDER BY sr.created_at DESC
         LIMIT 6         
            ";
                $result = mysqli_query($connection, $requestQuery);
                $serialNumber = 1;
                while ($request = mysqli_fetch_assoc($result)) {
            ?>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-target="#faqsTwo-1<?php echo $request['id'] ?>" type="button" data-bs-toggle="collapse">
                <h6><?php echo $serialNumber++; ?>.  <a href="request.php" class="fw-bold text-dark"><?php echo $request['user_name'] ?></a> report to <span class="fw-bold text-dark"><?php echo $request['servicer_name'] ?></span></h6>
                </button>
              </h2>
              <div id="faqsTwo-1<?php echo $request['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                <div class="accordion-body">
                <p><?php echo $request['report'] ?></p>
                </div>
              </div>
            </div>
           <?php } ?>
          </div>

        </div>
      </div><!-- End F.A.Q Group 2 -->

      <!-- F.A.Q Group 3 -->
      

    </div>

  </div>
</section>

</main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <?php include_once "include/layout/footer.php" ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <?php include_once "include/layout/js.php" ?>


</body>

</html>