<?php
// Database configuration
$hostname = "localhost"; // Usually "localhost" if the database is on the same server
$username = "root"; // Database username
$password = ""; // Database password
$database = "service1"; // Name of the database

// Create a database connection
$connection = mysqli_connect($hostname, $username, $password, $database);
$documentRoot = $_SERVER['DOCUMENT_ROOT']."\Service.com-PHP";
// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Perform database operations here...

// Close the connection when done
 
?>
