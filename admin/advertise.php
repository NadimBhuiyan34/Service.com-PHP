<?php
//  fetch category
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
}

// insert advertisement
if (isset($_POST['addAdvertise'])) {
  if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $target_dir = "public/advertise/";  // Directory where you want to save the uploaded images
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_name = basename($_FILES["image"]["name"]);
    }

    $title = $_POST['title'];
    $link = $_POST['link'];

    $insertQuery = "INSERT INTO `advertises`(`title`, `link`, `image`) VALUES ('$title','$link','$image_name')";
    if (mysqli_query($connection, $insertQuery)) {
      $message = "Advertisements add successfully.";

      // Redirect to the index.php page with the message
      header("Location: advertise.php?message=" . urlencode($message));
    } else {
      $message = "Something is wrong.";

      // Redirect to the index.php page with the message
      header("Location: advertise.php?message=" . urlencode($message));
    }
  } else {
    $message = "Image is required";

    // Redirect to the index.php page with the message
    header("Location: advertise.php?message=" . urlencode($message));
    exit;
  }
}

// edit advertisement
if (isset($_POST['editAdvertise'])) {
  if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $target_dir = "public/advertise/";  // Directory where you want to save the uploaded images
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_name = basename($_FILES["image"]["name"]);
    }
  } else {
    $image_name = $_POST['oldImage'];
  }

  $id = $_POST['id'];
  $title = $_POST['title'];
  $link = $_POST['link'];

  $updateQuery = "UPDATE `advertises` SET `title`='$title',`link`='$link',`image`='$image_name' WHERE id = $id";
  if (mysqli_query($connection, $updateQuery)) {
    $message = "Advertisements update successfully.";

    // Redirect to the index.php page with the message
    header("Location: advertise.php?message=" . urlencode($message));
  } else {
    $message = "Something is wrong.";

    // Redirect to the index.php page with the message
    header("Location: advertise.php?message=" . urlencode($message));
  }
}

// delete advertisement
if (isset($_POST['deleteAdv'])) {
  $id = $_POST['id'];
  $deleteQuery = "DELETE FROM `advertises` WHERE id = $id";
  if (mysqli_query($connection, $deleteQuery)) {
    $message = "Delete successfully.";

    // Redirect to the index.php page with the message
    header("Location: advertise.php?message=" . urlencode($message));
  } else {
    $message = "Something is wrong.";

    // Redirect to the index.php page with the message
    header("Location: advertise.php?message=" . urlencode($message));
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin-Advertisement</title>
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
    <div class="pagetitle d-flex justify-content-between">
      <div class="mt-3">
        <h1>Advertisement</h1>

        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Advertisement</li>
          </ol>
        </nav>
      </div>
      <div class="text-center p-2">
        <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:100px !important;height:75px !important" class="text-center">
      </div>

    </div><!-- End Page Title -->

    <section class="section faq">
      <div class="card">
        <div class="card-header">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAdvertise">
            <i class="fa-solid fa-plus"></i> Add New
          </button>
          <!-- add advertise modal -->
          <?php include_once "include/modal/advertise_modal.php" ?>
        </div>
        <div class="card-body">
          <div class="row">
            <?php
            $requestQuery = "SELECT * FROM `advertises` WHERE 1 ORDER BY id DESC";
            $result = mysqli_query($connection, $requestQuery);
            $serialNumber = 1;
            while ($advertise = mysqli_fetch_assoc($result)) {
            ?>
              <div class="col-lg-3 mt-3">

                <div class="card basic">


                  <h5 class="card-title p-2 text-center"><?php echo $advertise['title'] ?></h5>

                  <div class="card-body text-center">


                    <img src="public/advertise/<?php echo $advertise['image'] ?>" alt="" style="width:250px;height:300px">
                    <div>


                    </div>



                  </div>
                  <div class="card-footer d-flex justify-content-center gap-2">

                    <!-- edit modal -->
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm success" data-bs-toggle="modal" data-bs-target="#editAdvertise<?php echo $advertise['id'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- edit advertisement Modal -->
                    <div class="modal fade" id="editAdvertise<?php echo $advertise['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Edit Advertisements</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="advertise.php" method="POST" enctype="multipart/form-data">
                              <input type="hidden" name="id" value="<?php echo $advertise['id'] ?>">
                              <input type="hidden" name="oldImage" value="<?php echo $advertise['image'] ?>">
                              <div class="text-center">
                                <img src="public/advertise/<?php echo $advertise['image'] ?>" alt="" style="width:100px;height:150px">
                              </div>
                              <div class="mb-3">
                                <label for="title" class="form-label text-black fw-bold">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $advertise['title'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="image" class="form-label text-black fw-bold">Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                              </div>
                              <div class="mb-3">
                                <label for="link" class="form-label text-black fw-bold">Site Link</label>
                                <input type="link" class="form-control" name="link" id="link" value="<?php echo $advertise['link'] ?>">
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editAdvertise">Save changes</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- end edit modal -->

                    <form action="advertise.php" method="POST" class="deleteForm">
                      <input type="hidden" value="<?php echo $advertise['id']; ?>" name="id">
                    
                      <button type="submit" class="btn btn-outline-danger btn-sm" name="deleteAdv">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </form>

                  </div>
                </div>

                <!-- F.A.Q Group 1 -->


              </div>
            <?php } ?>


          </div>
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