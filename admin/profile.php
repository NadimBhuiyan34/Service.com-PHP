<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
}
$id = $_SESSION['user_id'];
$stmt = $connection->prepare("SELECT u.id, u.name, u.mobile, u.password, u.email, up.profile_image, up.address
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $mobile, $hashed_password, $email, $profile_image, $address);
$stmt->fetch();

// profile update

if (isset($_POST['profileUpdate'])) {
  // Image handling
  if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == 0) {
    $target_dir = "public/profile/";  // Directory where you want to save the uploaded images
    $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
      $profile_name = basename($_FILES["profileImage"]["name"]);
      // You can now save the file name or path to your database for future reference.
    }
  }

  $id = $_SESSION['user_id'];
  $name = $_POST['fullName'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $mobile = $_POST['phone'];

  $profile = $profile_name ?? $_POST['profileImageName'];

  $userQuery = "UPDATE `users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`updated_at`= NOW() WHERE id = $id";
  // Now, you can use the $profile variable in your code.
  $userResult = mysqli_query($connection, $userQuery);

  $profileQuery = "UPDATE `user_profiles` SET `address`='$address',`profile_image`='$profile',`updated_at`= NOW() WHERE user_id = $id";
  $profileResult = mysqli_query($connection, $profileQuery);

  if ($userResult && $profileResult) {
    $message = "Profile update successfully.";

    // Redirect to the index.php page with the message
    header("Location: profile.php?message=" . urlencode($message));
    exit;
  } else {
    $message = "Something is wrong.";

    // Redirect to the index.php page with the message
    header("Location: profile.php?message=" . urlencode($message));
    exit;
  }
}

// change password

if (isset($_POST['changePassword'])) {
  $id = $_POST['user_id'];
  $old_password = md5($_POST['password']);
  $new_password = md5($_POST['newpassword']);

  // Step 1: Verify that the old password matches the current password
  $passwordQuery = "SELECT password FROM users WHERE id = ?";
  $stmt = $connection->prepare($passwordQuery);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($hashed_password);
  $stmt->fetch();
  $stmt->close(); // Close the prepared statement

  if ($old_password === $hashed_password) {
    // Step 2: The old password matches, now you can proceed with updating the password

    $updatePasswordQuery = "UPDATE users SET password = ? WHERE id = ?";
    $updateStmt = $connection->prepare($updatePasswordQuery);
    $updateStmt->bind_param("si", $new_password, $id);
    $updateStmt->execute();
    $updateStmt->close(); // Close the prepared statement

    // Password updated successfully
    $message = "Password changed successfully.";

    // Redirect to the profile.php page with the message
    header("Location: profile.php?message=" . urlencode($message));
    exit;
  } else {
    // Old password does not match
    $message = "Your old password is incorrect.";

    // Redirect to the profile.php page with the message
    header("Location: profile.php?message=" . urlencode($message));
    exit;
  }
}







?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
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
        <h1>My Profile</h1>

        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">My Profile</li>
          </ol>
        </nav>
      </div>
      <div class="text-center p-2">
        <img src="https://otp799999.000webhostapp.com/frontend/image/The-search.png" alt="" style="width:100px !important;height:75px !important" class="text-center">
      </div>

    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="public/profile/<?php echo  $profile_image ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $_SESSION['name']; ?></h2>
              <h3>Admin</h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <!-- <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
            </li> -->

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $name ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8">Idea Solution Ltd</div>
                  </div>



                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">Bangladesh</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo $address ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $mobile ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $email ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img id="previewImage" src="public/profile/<?php echo $profile_image ?>" alt="Profile" style="width: 300px; height: 100px">
                        <div class="pt-2">
                          <label for="profileImageUpload" class="btn btn-primary btn-sm text-white px-5 fs-6" title="Upload new profile image">
                            <i class="bi bi-upload"></i>
                          </label>
                          <input type="file" id="profileImageUpload" name="profileImage" style="display: none;" onchange="displayImage(this);">
                        </div>
                      </div>
                    </div>

                    <input type="hidden" name="profileImageName" value="<?php echo $profile_image ?>">

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $name ?>">
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" value="<?php echo $address ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $mobile ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?php echo $email ?>">
                      </div>
                    </div>





                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="profileUpdate">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="profile.php" method="POST">

                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" oninput="validatePasswordMatch()">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" style="border-color: red;" oninput="validatePasswordMatch()">
                        <span id="passwordMatchMessage" style="color: red;"></span>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" id="changePasswordButton" name="changePassword" disabled>Change Password</button>
                    </div>
                  </form>
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
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

  <script>
    function displayImage(input) {
      var preview = document.getElementById('previewImage');

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>

  <script>
    function validatePasswordMatch() {
      const newPasswordInput = document.getElementById("newPassword");
      const renewPasswordInput = document.getElementById("renewPassword");
      const passwordMatchMessage = document.getElementById("passwordMatchMessage");
      const changePasswordButton = document.getElementById("changePasswordButton");

      const newPassword = newPasswordInput.value;
      const renewPassword = renewPasswordInput.value;

      if (newPassword !== renewPassword) {
        passwordMatchMessage.textContent = "Passwords do not match";
        renewPasswordInput.style.borderColor = "red";
        changePasswordButton.disabled = true;
      } else {
        passwordMatchMessage.textContent = "";
        renewPasswordInput.style.borderColor = "initial";
        changePasswordButton.disabled = false;
      }
    }
  </script>



</body>

</html>