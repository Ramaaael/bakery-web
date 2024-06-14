<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile_or_email = $_POST['mobile_or_email'];
    $full_name = $_POST['full_name'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing dengan bcrypt

    // Memeriksa apakah username sudah ada
    $check_sql = "SELECT id FROM regist WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error_message = "Username sudah terdaftar. Silakan gunakan username lain.";
    } else {
        // Menyimpan data baru
        $sql = "INSERT INTO regist (mobile_or_email, full_name, alamat, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssss", $mobile_or_email, $full_name, $alamat, $username, $password);

            if ($stmt->execute() === TRUE) {
                $success_message = "Pendaftaran berhasil!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
include "signup.html";
?>

