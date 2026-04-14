<?php
$host = "localhost";
$user = "root"; // Change this for your hosting (e.g., InfinityFree)
$pass = "";     // Change this for your hosting
$db_name = "school_system";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>