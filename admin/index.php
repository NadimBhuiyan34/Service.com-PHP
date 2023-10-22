<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) {
  if (isset($_POST['login'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
      $email = $_POST['email'];
      $user_input_password = $_POST['password'];
      // Convert the user input password to MD5
      $md5_user_input_password = md5($user_input_password);

      // Replace with your database connection details
      $stmt = $connection->prepare("SELECT u.id, u.name, u.password, up.profile_image
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id, $name, $hashed_password, $profile_image);
      $stmt->fetch();


      if ($md5_user_input_password === $hashed_password) {
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name; // Store the user's name in the session
        $_SESSION['profile_image'] = $profile_image; // Store the user's name in the session
        // $_SESSION['profile_image'] = $profile_image;
        header("Location: dashboard.php"); // Redirect to a dashboard or home page

      } else {
        $message = "Incorrect Username or Password.";
        header("Location: index.php?message=" . urlencode($message));
        exit;
      }

      $stmt->close();
      $connection->close();
    }
  }
} else {
  $message = "Your are already login now.";
  header("Location: dashboard.php?message=" . urlencode($message));
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
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

  <main>
    <div class="container">
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
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <!-- <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="">
                  <img src="../frontend/img/Logo-NPL.png" class="px-2" alt="" style="width:180px; height:100px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform = 'scale(1.1)';" onmouseout="this.style.transform = 'scale(1)';">
                </a>
              </div> -->
              <!-- End Logo -->

              <div class="card  rounded-4 shadow">
                <div class="d-flex justify-content-center pt-3">
                  <a href="index.php" class="">
                    <img src="../frontend/image/The-search.png" class="px-2" alt="" style="width:180px; height:130px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform = 'scale(1.1)';" onmouseout="this.style.transform = 'scale(1)';">
                  </a>
                </div>
                <div class="card-body">

                  <div class="pt-2 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="index.php" method="POST">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div> -->
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include_once "include/layout/js.php" ?>

</body>

</html>