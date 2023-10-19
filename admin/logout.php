<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    // Unset or destroy the session variables
    // unset($_SESSION['user_id']);
    // unset($_SESSION['name']);
    // unset($_SESSION['email']);
  
    // Alternatively, you can destroy the entire session
    session_destroy();
  
    // Redirect the user to the login page or any other appropriate page
    header("Location: index.php"); // Replace 'login.php' with your login page
    exit;
  } 
  else{
    header("Location: dashboard.php"); // Replace 'login.php' with your login page
    exit;
  }

?>