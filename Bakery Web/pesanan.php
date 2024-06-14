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

// Query untuk mendapatkan informasi pelanggan dan total belanja
$customer_id = 1; // Ganti dengan customer_id yang sesuai
$sql_customer = "SELECT full_name, alamat, mobile_or_email FROM regist WHERE id = $customer_id";
$result_customer = $conn->query($sql_customer);

// Ambil informasi pelanggan
$customer_full_name = "";
$customer_alamat = "";

if ($result_customer->num_rows > 0) {
    $row_customer = $result_customer->fetch_assoc();
    $customer_full_name = $row_customer["full_name"];
    $customer_alamat = $row_customer["alamat"];
}

// Query untuk menghitung total belanja
$sql_total = "SELECT SUM(menu_items.price * orders.quantity) AS total_harga
              FROM orders
              JOIN menu_items ON orders.menu_id = menu_items.menu_id
              WHERE orders.customers_id = $customer_id";
$result_total = $conn->query($sql_total);

$total_harga = 0;

if ($result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_harga = $row_total["total_harga"];
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
    <title>Clarabele Bakery Supply</title>

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
    <link rel="stylesheet" href="css/style.css">
    
    
    

    <!-- Modernizr JS for IE8 support of HTML5 elements and media queries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
</head>
<body>
<nav id="navbar-header" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand navbar-brand-center d-flex align-items-center p-0 only-mobile" href="#">
            <img src="img/logo clarabele_png.png" alt="">
        </a>
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
                <a class="navbar-brand navbar-brand-center align-items-center only-desktop" href="#">
                <img src="img/logo clarabele_png.png" alt="" >
                </a>
            
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
        <h1>Form Pesanan</h1>
        <form action="proses_pesanan.php" method="POST" class="form-pesanan">
            <div class="form-group">
                <label for="full_name">Nama Pelanggan:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $customer_full_name; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Pelanggan:</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3" readonly><?php echo $customer_alamat; ?></textarea>
            </div>
            <div class="form-group">
                <label for="total_harga">Total Harga yang Harus Dibayar:</label>
                <input type="text" id="total_harga" name="total_harga" class="form-control" value="Rp <?php echo $total_harga !== null ? number_format($total_harga, 2) : '0.00'; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <select id="metode_pembayaran" name="metode_pembayaran" class="form-control" required>
                    <option value="">Pilih metode pembayaran</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Kartu Kredit">Kartu Kredit</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Pesanan</button>
        </form>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="vendor/bootstrap/popper.min.js"></script>
	<script src="vendor/bootstrap/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js "></script>
	<script src="vendor/owlcarousel/owl.carousel.min.js"></script>
	<script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
	<script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
	<!-- Main JS -->
	<script src="js/app.min.js "></script>
    <script src="js/main.js "></script>
   
</body>
</html>