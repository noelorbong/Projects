<?php
$servername = "sql211.byethost.com";
$username = "b31_22600496";
$password = "trackerkey";
$database = "b31_22600496_tracker_holder";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>