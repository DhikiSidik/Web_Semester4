<?php
session_start();
include '../koneksi.php';

// Function to get the cart count from the server using AJAX
function getCartCount()
{
    include '../koneksi.php';
    if (isset($_SESSION['user_id'])) {
        $idUser = $_SESSION['user_id'];
        $queryCount = "SELECT COUNT(*) as total FROM keranjang WHERE idUser = $idUser";
        $resultCount = mysqli_query($koneksi, $queryCount);
        $row = mysqli_fetch_assoc($resultCount);
        return $row['total'];
    } else {
        return 0;
    }
}

function getOrderCount()
{
    include '../koneksi.php';
    if (isset($_SESSION['user_id'])) {
        $idUser = $_SESSION['user_id'];
        $queryCount = "SELECT COUNT(*) as total FROM sewa WHERE idUser = $idUser";
        $resultCount = mysqli_query($koneksi, $queryCount);
        $row = mysqli_fetch_assoc($resultCount);
        return $row['total'];
    } else {
        return 0;
    }
}

// Add an initial cart count value to be displayed before the AJAX request
$jumlahBarangKeranjang = getCartCount();
$jumlahPesanan = getOrderCount();

// Handle AJAX request to remove item from the cart
if (isset($_POST['action']) && $_POST['action'] == 'remove_item') {
    $idUser = $_SESSION['user_id'];
    $itemId = $_POST['item_id'];
    $queryDelete = "DELETE FROM keranjang WHERE idUser = $idUser AND id = $itemId";
    $resultDelete = mysqli_query($koneksi, $queryDelete);
    // Respond to the client-side AJAX request
    echo json_encode(['status' => 'success']);
    exit;
}
// ...

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

// If a category is selected, modify the SQL query to include the JOIN and WHERE clause
$query = "SELECT *, CONCAT('../ASSET/alat/', foto) AS foto FROM barang";

if ($selectedCategory && $selectedCategory !== 'All') {
    $query .= " JOIN kategori ON barang.idKategori = kategori.id";
    $query .= " WHERE kategori.jenis = '$selectedCategory'";
} else {
}
$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Hiktools</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="styleUser.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hiktools</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?category=All">Semua</a></li>
                            <li><a class="dropdown-item" href="?category=Tas Punggung">Tas Punggung</a></li>
                            <li><a class="dropdown-item" href="?category=Tenda">Tenda</a></li>
                            <li><a class="dropdown-item" href="?category=Perkakas Memasak">Perkakas Memasak</a></li>
                            <li><a class="dropdown-item" href="?category=Peralatan Tidur">Peralatan Tidur</a></li>
                            <li><a class="dropdown-item" href="?category=Pakaian">Pakaian</a></li>
                            <li><a class="dropdown-item" href="?category=Lainnya">Lainnya</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">Tentang kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/qr/OT5SCJB2TOSLN1">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-secondary" id="cartBadge"><?php getCartCount(); ?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pesanan.php">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="badge bg-secondary" id="orderBadge"><?php getOrderCount(); ?></span>
                        </a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                    <button class="btn btn-outline-success" type="submit" id="submit" name="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <header class="header">
        <div class="jumbotron jumbotron-fluid">
            <div class="tes">
                <h1><b>Selamat datang di Hiktools</b></h1>
                <h3 class="lead">Temukan alat-alat hiking dengan harga yang terjangkau</h3>
            </div>
        </div>
    </header>

    <div class="loading">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>

    <div class="container">
        <h2>Daftar Alat Tersedia</h2>
        <div class="product-container" id="content">
            <?php

            // Menampilkan data ke dalam produk
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo $row['foto']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nama_barang']; ?></h5>
                        <p class="card-text">Harga: <?php echo $row['harga']; ?></p>

                        <a href="#" class="btn btn-primary popup-trigger" data-nama-barang="<?php echo $row['nama_barang']; ?>" data-stock="<?php echo $row['stok']; ?>" data-target="#myModal">Add to cart</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>


   

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="add_to_cart.php" method="POST" id="addToCartForm">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Informasi Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p name="namaBarang" id="modalNamaBarang"></p>
                        <p id="modalStok"></p>
                        <p id="modalHarga"></p>
                        <div class="form-group">
                            <label for="quantity">Jumlah:</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1">
                            <div id="quantityError" class="text-danger"></div> <!-- Tambahkan div untuk menampilkan pesan kesalahan -->
                        </div>

                        <input type="hidden" name="namaBarang" id="inputNamaBarang" value="">
                        <input type="hidden" name="stok" id="inputStok" value="">
                        <input type="hidden" name="harga" id="inputHarga" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary addToCart">Tambahkan ke Keranjang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function updateCartBadgeCount(count) {
            const cartBadge = document.getElementById('cartBadge');
            cartBadge.textContent = count;
        }

        function updateOrderBadgeCount(count) {
            const orderBadge = document.getElementById('orderBadge');
            orderBadge.textContent = count;
        }

        $(document).ready(function() {
            updateCartBadgeCount(<?php echo $jumlahBarangKeranjang; ?>);
            updateOrderBadgeCount(<?php echo $jumlahPesanan; ?>);
            $('.dropdown-item').click(function() {
                $('#searchInput').val(''); // Reset the search input
            });
            $(".popup-trigger").click(function() {
                var targetModal = $(this).data("target");
                var namaBarang = $(this).data("nama-barang");
                var stok = $(this).data("stock");
                var harga = $(this).siblings(".card-text").text().replace("Harga: ", "");

                // Memasukkan nilai ke dalam elemen modal
                $(targetModal).find("#modalNamaBarang").text("Nama Barang: " + namaBarang);
                $(targetModal).find("#modalStok").text("Stok: " + stok);
                $(targetModal).find("#modalHarga").text("Harga : " + harga);
                $(targetModal).modal("show");

                // Update the form action attribute with the correct namaBarang
                $("#addToCartForm").attr("action", "add_to_cart.php");

                // Set the hidden input values with the item details
                $("#inputNamaBarang").val(namaBarang);
                $("#inputStok").val(stok);
                $("#inputHarga").val(harga);

                // Update the addToCart button click event
                $("#addToCartForm").submit(function(e) {
                    e.preventDefault(); // Prevent default form submission
                    var formData = new FormData(this); // Get form data

                    // Send data to add_to_cart.php using AJAX
                    addToCart(formData);
                });
            });

        });


        function addToCart(formData) {
            var jumlah = parseInt($('#quantity').val());
            var stok = parseInt($('#inputStok').val());

            if (jumlah > stok) {
                // Jumlah melebihi stok, tampilkan pesan kesalahan
                $('#quantityError').text('Jumlah melebihi stok yang tersedia.');
            } else {
                // Jumlah valid, lanjutkan dengan mengirim data menggunakan AJAX
                $.ajax({
                    type: "POST",
                    url: "add_to_cart.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response); // For debugging
                        if (response === "success") {
                            Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Item berhasil ditambahkan ke keranjang',
                            showConfirmButton: false,
                            timer: 1500
                            })
                            
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                        } else {
                            alert("Error occurred while adding to cart.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // For debugging
                        alert("Error occurred while adding to cart.");
                    }
                });
                updateCartBadgeCount();
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var value = $(this).val().toLowerCase();
                document.querySelector('.loading').style.display = 'flex';

                setTimeout(function() {
                    $('#content .card').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });

                    $('.loading').hide(); // Menyembunyikan animasi loading setelah delay selesai
                }, 1000); // Delay 1000ms (1 detik)
            });
        });
    </script>

</body>

<!-- Remove the container if you want to extend the Footer to full width. -->


  <footer id ="footer" style="background-color: #F3F3F3;">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
          <h5 class="mb-3 text-dark">Hiktools</h5>
          <p>
          Selamat datang di Hiktools, destinasi terbaik untuk menyewa peralatan hiking berkualitas tinggi. Dengan pilihan peralatan yang beragam, <br> mudah digunakan, dan layanan pelanggan 24/7, kami memastikan setiap petualangan mendaki Anda menjadi lebih nyaman dan seru. Dengan Hiktools, tingkatkan pengalaman mendaki Anda tanpa harus memiliki semua peralatan sendiri.
          </p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-5">
          <h5 class="mb-3 text-dark">links</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="#!" style="color: #4f4f4f;">FAQ</a>
            </li>
            <li class="mb-1">
              <a href="#content" style="color: #4f4f4f;">Produk</a>
            </li>
            <li class="mb-1">
              <a href="#navbarSupportedContent" style="color: #4f4f4f;">Kategori</a>
            </li>
            <li>
              <a href="https://wa.me/qr/OT5SCJB2TOSLN1" style="color: #4f4f4f;">Kontak Kami</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-1 text-dark">opening hours</h5>
          <table class="table" style="border-color: #666;">
            <tbody>
              <tr>
                <td>Mon - Fri:</td>
                <td>8am - 9pm</td>
              </tr>
              <tr>
                <td>Sat - Sun:</td>
                <td>8am - 1am</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 Copyright:
      <a class="text-dark" href="#">Hiktools</a>
    </div>
    <!-- Copyright -->
  </footer>
  

<!-- End of .container -->

</html>