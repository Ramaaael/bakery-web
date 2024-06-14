<?php
session_start();

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM regist WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Memverifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_id'] = $user['id'];
            
            header("Location: index2.php"); 
            exit();
        } else {
            $message = "Password salah.";
        }
    } else {
        $message = "Nama pengguna tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();

// Include form login di sini
include "signin.html";
?>
