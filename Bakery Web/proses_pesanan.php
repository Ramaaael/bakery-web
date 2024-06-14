<?php
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangani form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan melalui form
    $customer_id = 1; // Ganti dengan customer_id yang sesuai
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Lakukan validasi
    if (empty($metode_pembayaran)) {
        $error_message = "Mohon pilih metode pembayaran.";
    } else {
        // Simpan pesanan atau lakukan operasi lain sesuai kebutuhan
        // Misalnya, masukkan ke dalam database atau lakukan operasi pembayaran

        // Contoh: Simpan ke dalam database
        $sql_insert_pesanan = "INSERT INTO pesanan (customer_id, metode_pembayaran) VALUES ('$customer_id', '$metode_pembayaran')";

        if ($conn->query($sql_insert_pesanan) === TRUE) {
            $success_message = "Pesanan Anda telah berhasil diproses.";
        } else {
            $error_message = "Terjadi kesalahan saat memproses pesanan: " . $conn->error;
        }
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pesanan</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.min.css">

    <!-- Modernizr JS for IE8 support of HTML5 elements and media queries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
</head>
<body>

<nav id="navbar-header" class="navbar navbar-expand-lg">
    <div class="container">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="lnr lnr-menu"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-between">
                <div class="d-flex flex-lg-row flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="index2.php">Home</a>
                    </li>
                </div>
            </ul>
            <ul class="navbar-nav">
                
                <ul class="navbar-nav d-flex justify-content-between">
                    <div class="d-flex flex-lg-row flex-column">
                        <li class="nav-item active">
                            <a class="nav-link" href="menu.php">Menu</a>
                        </li> 
                        <li class="nav-item active">
                            <a class="nav-link" href="keranjang.php">Keranjang</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="pesanan.php">Pesanan</a>
                        </li>
                    </div>
                    <div class="d-flex flex-lg-row flex-column">
                        <li class="nav-item">
                            <a class="btn btn-sign btn-shadow btn-lg" href="index.html" role="button">Logout</a>
                        </li>
                    </div>
                </ul>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Proses Pesanan</h1>

    <?php if(isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>

    <?php if(isset($success_message)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
    <?php endif; ?>

    <a href="pesanan.php" class="btn btn-primary">Kembali ke Form Pesanan</a>
</div>

<!-- External JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="vendor/bootstrap/popper.min.js"></script>
<script src="vendor/bootstrap/bootstrap.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/owlcarousel/owl.carousel.min.js"></script>
<script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
<script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<!-- Main JS -->
<script src="js/app.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
