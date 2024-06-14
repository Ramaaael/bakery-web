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

// Update quantity atau hapus item jika ada permintaan POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    if ($_POST['action'] == 'update_quantity') {
        if ($quantity > 0) {
            $stmt = $conn->prepare("UPDATE orders SET quantity = ? WHERE menu_id = ?");
            $stmt->bind_param("ii", $quantity, $menu_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("DELETE FROM orders WHERE menu_id = ?");
            $stmt->bind_param("i", $menu_id);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($_POST['action'] == 'delete_item') {
        $stmt = $conn->prepare("DELETE FROM orders WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Query untuk mendapatkan data dari tabel orders dan menu
$sql = "SELECT orders.menu_id, menu_items.name, menu_items.price, menu_items.image_url, orders.quantity, (menu_items.price * orders.quantity) AS total_price
        FROM orders
        JOIN menu_items ON orders.menu_id = menu_items.menu_id";
$result = $conn->query($sql);

// Inisialisasi total keseluruhan harga
$total_all = 0;

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
    <link rel="stylesheet" href="css/keranjang.css">
    
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
<hr>
<center> 
<div class="container">
    <h1>Keranjang Belanja</h1>
    <form action="" method="POST" class="form-pes">
        <table width="90%" style="text-align:center;">
            <tr >
                <th>Menu</th>
                <th>Nama</th>
                <th>Harga Satuan</th>
                <th>Quantity</th>
                <th>Harga Total</th>
                <th>Hapus Pesanan</th>
            </tr>

            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $total_all += $row["total_price"];
                    ?>
                    <tr>
                        <td><img src="<?php echo $row["image_url"]; ?>" width="100" height="100"></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td>Rp <?php echo number_format($row["price"], 2); ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline-block;">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="<?php echo ($row["quantity"] - 1); ?>">
                                <input type="hidden" name="action" value="update_quantity">
                                <button type="submit" name="update_quantity">-</button>
                            </form>
                            <?php echo $row["quantity"]; ?>
                            <form action="" method="POST" style="display:inline-block;">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="<?php echo ($row["quantity"] + 1); ?>">
                                <input type="hidden" name="action" value="update_quantity">
                                <button type="submit" name="update_quantity">+</button>
                            </form>
                        </td>
                        <td>Rp <?php echo number_format($row["total_price"], 2); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="0">
                                <input type="hidden" name="action" value="delete_item">
                                <button type="submit" name="delete_item">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr >
                    <td colspan="4" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                    <td ><strong>Rp <?php echo number_format($total_all, 2); ?></strong></td>
                    <td></td>
                </tr>
                <?php
            } else {
                echo "<tr><td colspan='6'>Keranjang belanja kosong.</td></tr>";
            }
            ?>
        </table>
    </form>
</div>
</center>
<center><a class="btn-pes" href="pesanan.php">Pesan Sekarang</a></center>

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
