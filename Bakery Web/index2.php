<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

$full_name = $_SESSION['full_name'];
$username = $_SESSION['username'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


include "index2.html";
?>