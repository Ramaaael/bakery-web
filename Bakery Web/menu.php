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

// Pastikan ini adalah file yang diakses dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim melalui fetch API
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['itemId']) && isset($data['quantity'])) {
        $menu_id = $data['itemId'];
        $quantity = $data['quantity'];
        
        // Contoh: Ambil ID pelanggan dari sesi atau dari data yang ada
        // Ini perlu disesuaikan dengan logika aplikasi Anda
        $customers_id = 1; // Ganti dengan cara yang sesuai untuk mendapatkan ID pelanggan

        // Query untuk menyimpan data ke dalam tabel orders
        $sql = "INSERT INTO orders (customers_id, menu_id, quantity) VALUES (?, ?, ?)";
        
        // Persiapkan statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameter ke statement
        $stmt->bind_param("iii", $customers_id, $menu_id, $quantity);
        
        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil disimpan, arahkan ke halaman yang sesuai
            header('Location: keranjang.php');
            exit();
        } else {
            // Jika terjadi kesalahan
            echo "Gagal menambahkan pesanan ke keranjang: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika data menu_id atau quantity tidak ditemukan dalam request
        echo "Data yang diperlukan tidak lengkap.";
    }
}

// Tutup koneksi database
$conn->close();
?>





<!DOCTYPE html>
<!--
	Resto by GetTemplates.co
	URL: https://gettemplates.co
-->
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Resto - Restaurant Bootstrap 4 Template by GetTemplates.co</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
<body data-spy="scroll" data-target="#navbar">
 	
</div>	<div id="canvas-overlay"></div>
	<div class="boxed-page">
		<nav id="navbar-header" class="navbar navbar-expand-lg">
    
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="lnr lnr-menu"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-between">
                <li class="nav-item only-desktop">
                    <a class="nav-link" id="side-nav-open" href="#">
                        <span class="lnr lnr-menu"></span>
                    </a>
                </li>
                <div class="d-flex flex-lg-row flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="index2.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Special Dishes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="special-dishes.html">Beef Steak Sauce</a>
                            <a class="dropdown-item" href="special-dishes.html">Salmon Zucchini</a>
                        </div>
                    </li>
                </div>
            </ul>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="reservation.html">Reservation</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="keranjang.php">Keranjang</a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>		
<?php include "page/menu.html" ?>

<!-- End of menu Section -->

<footer class="mastfoot pb-5 bg-white section-padding pb-0">
    <div class="inner container">
         <div class="row">
         	<div class="col-lg-4">
         		<div class="footer-widget pr-lg-5 pr-0">
         			<img src="img/logo.png" class="img-fluid footer-logo mb-3" alt="">
	         		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et obcaecati quisquam id sit omnis explicabo voluptate aut placeat, soluta, nisi ea magni facere, itaque incidunt modi? Magni, et voluptatum dolorem.</p>
	         		<nav class="nav nav-mastfoot justify-content-start">
		                <a class="nav-link" href="#">
		                	<i class="fab fa-facebook-f"></i>
		                </a>
		                <a class="nav-link" href="#">
		                	<i class="fab fa-twitter"></i>
		                </a>
		                <a class="nav-link" href="#">
		                	<i class="fab fa-instagram"></i>
		                </a>
		            </nav>
         		</div>
         		
         	</div>
         	<div class="col-lg-4">
         		<div class="footer-widget px-lg-5 px-0">
         			<h4>Open Hours</h4>
	         		<ul class="list-unstyled open-hours">
		                <li class="d-flex justify-content-between"><span>Monday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Tuesday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Wednesday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Thursday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Friday</span><span>9:00 - 02:00</span></li>
		                <li class="d-flex justify-content-between"><span>Saturday</span><span>9:00 - 02:00</span></li>
		                <li class="d-flex justify-content-between"><span>Sunday</span><span> Closed</span></li>
		              </ul>
         		</div>
         		
         	</div>

         	<div class="col-lg-4">
         		<div class="footer-widget pl-lg-5 pl-0">
         			<h4>Newsletter</h4>
	         		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
	         		<form id="newsletter">
						<div class="form-group">
							<input type="email" class="form-control" id="emailNewsletter" aria-describedby="emailNewsletter" placeholder="Enter email">
						</div>
						<button type="submit" class="btn btn-primary w-100">Submit</button>
					</form>
         		</div>
         		
         	</div>
         	<div class="col-md-12 d-flex align-items-center">
         		<p class="mx-auto text-center mb-0">Copyright 2019. All Right Reserved. Design by <a href="https://gettemplates.co" target="_blank">GetTemplates</a></p>
         	</div>
            
        </div>
    </div>
</footer>	</div>
	
</div>
	<!-- External JS -->
    <!-- <script src="js/menu.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="vendor/bootstrap/popper.min.js"></script>
	<script src="vendor/bootstrap/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js "></script>
	<script src="vendor/owlcarousel/owl.carousel.min.js"></script>
	<script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
	<script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

	<!-- Main JS -->

    <!-- <script>
         document.addEventListener("DOMContentLoaded", function() {
            const plusBtn = document.querySelectorAll(".plus");
            const minusBtn = document.querySelectorAll(".minus");
            const countInput = document.querySelectorAll(".count");

            plusBtn.forEach(button => {
                button.addEventListener("click", function() {
                    const input = this.parentElement.querySelector(".count");
                    input.value = parseInt(input.value) + 1;
                });
            });

            minusBtn.forEach(button => {
                button.addEventListener("click", function() {
                    const input = this.parentElement.querySelector(".count");
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                });
            });

            const addToCartBtns = document.querySelectorAll(".add-to-cart");
            addToCartBtns.forEach(button => {
                button.addEventListener("click", function() {
                    const itemId = this.getAttribute('data-item-id');
                    const quantity = parseInt(this.parentElement.querySelector(".count").value);

                    // Kirim data ke index.php menggunakan fetch API
                    fetch('menu.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ itemId, quantity })
                    })
                    .then(response => response.text())
                    .then(data => {
                        const responseContainer = document.querySelector(".response-container");
                        responseContainer.innerHTML = `<p>${data}</p>`;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script> -->
</body>
</html>
