<?php
// Connection details
$host = "localhost";
$user = "222013529";
$pass = "222013529";
$database = "Online_Stress_Management_Workshops_Platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>