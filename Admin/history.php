<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="bootcatch sidebar is simple single page template with sidebar based on bootstrap, it's starter template for admin template - thanks :)">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    <title>Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://kit.fontawesome.com/9313f7f8f2.js" crossorigin="anonymous"></script>
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <style>
    .card-header {
        margin-top : 10px;
    }
    td button {
    margin-right: 10px;
    margin-bottom: 10px; 
    }
    #hide-me {
        display: none;
    }
    </style>
    <script>
    $(document).ready(function () {
        // Function to filter table rows based on the search query
        function filterTable(query) {
            query = query.trim().toLowerCase(); // Convert the search query to lowercase for case-insensitive search
            let found = false;

            $("tbody tr").each(function () {
                const nama = $(this).find("td:nth-child(2)").text().toLowerCase(); // Get the "Nama Barang" value from the third column
                const username = $(this).find("td:nth-child(3)").text().toLowerCase(); // Get the "Kategori" value from the fourth column

                if (nama.indexOf(query) === -1 && username.indexOf(query) === -1) {
                    $(this).hide(); // Hide the row if the search query is not found in the "Nama Barang" and "Kategori" columns
                } else {
                    $(this).show(); // Show the row if the search query is found in either the "Nama Barang" or "Kategori" columns
                    found = true;
                }
            });

            // Show the message if no matching items are found
            if (!found) {
                $(".no-results").show();
            } else {
                $(".no-results").hide();
            }
        }

        // Event handler for the search button click
        $(".btn-outline-secondary").click(function () {
            const searchQuery = $("input.form-control").val();
            filterTable(searchQuery);
        });

        // Event handler for the Enter key press in the search input
        $("input.form-control").keypress(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault(); // Prevent form submission on Enter key press
                const searchQuery = $(this).val();
                filterTable(searchQuery);
            }
        });
    });
</script>
</head>

<body>

    <div id="main-wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a class="d-flex align-items-center" >
                        Hiktools
                    </a>
                </li>
                <li>
                    <a href="admin.php">Tambah Barang</a>
                </li>
                <li>
                    <a href="pengambilan.php">Pengambilan Barang</a>
                </li>
                <li>
                    <a href="pengembalian.php">Pengembalian Barang</a>
                </li>
                <?php if ($_SESSION['user_role'] == 3): ?>
                <li>
                    <a href="kelolaadm.php">Kelola Admin</a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="history.php">History</a>
                </li>
                <li >
                    <a href="../login.php">Log Out</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar -->

        <!-- Page Content -->
        <div id="main-content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<ul class="navbar-nav  d-flex align-items-center ">
			      <li class="nav-item active mobile-view">
			        <a class="nav-link d-flex align-items-center" href="#menu-toggle"  id="menu-toggle">
			        	<i class="material-icons">menu</i>
			        	<span class="sr-only">(current)</span></a>
			      </li>
			  	</ul>
                  <form class="form-inline ml-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
			</nav>
			<!-- navbar ends -->
            <div class="container-fluid">
                <div class="card-header text-white bg-dark text-lg-center">
                    History
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">ID Pemesanan</th>
                                <th scope="col">Tanggal Pesan</th>
                                <th scope="col">Tanggal Kembali</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../koneksi.php";
                            $sql = "SELECT 
                            pesanan.idPesanan, pesanan.idUser, pesanan.tanggalPesan, pesanan.totalHarga, pesanan.status, 
                            user.id, user.username, sewa.idUser, sewa.nama_barang, sewa.jumlah, sewa.lama_sewa_start, sewa.lama_sewa_end 
                            FROM pesanan INNER JOIN user ON pesanan.idUser = user.id INNER JOIN sewa ON sewa.idUser = user.id WHERE pesanan.status = 'done'
                            ORDER BY user.username ASC LIMIT 1;";
                            $query = mysqli_query($koneksi, $sql);
                            $urut = 1;
                            while ($result = mysqli_fetch_array($query)) {
                                $username = $result['username'];
                                $id = $result['id'];
                                $tgl_ambil = $result['tanggalPesan'];
                                $tgl_kembali = $result['lama_sewa_end'];
                                $harga = $result['totalHarga'];
                                $idPesanan = $result['idPesanan'];
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++; ?></th>
                                    <td scope="row"><?php echo $username; ?></td>
                                    <td scope="row"><?php echo $id; ?></td>
                                    <td scope="row"><?php echo $tgl_ambil; ?></td>
                                    <td scope="row"><?php echo $tgl_kembali; ?></td>
                                    <td scope="row"><?php echo $harga; ?></td>
                                    <td scope="row">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#view">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="no-results" style="display: none; text-align: center; margin-top: 10px; color: red;">Nama atau Username tidak ditemukan</div>
                </div>
            </div>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tanggal Ambil</th>
                                <th scope="col">Tanggal Kembali</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../koneksi.php";
                            $sql = "SELECT pesanan.idPesanan, pesanan.idUser, pesanan.tanggalPesan, pesanan.totalHarga, pesanan.status, user.id, user.username, sewa.idUser, sewa.nama_barang, sewa.jumlah, sewa.lama_sewa_start, sewa.lama_sewa_end, sewa.total_harga FROM pesanan INNER JOIN user ON pesanan.idUser = user.id INNER JOIN sewa ON sewa.idUser = user.id
                                ORDER BY sewa.nama_barang;";
                            $query = mysqli_query($koneksi, $sql);
                            $urut = 1;
                            while ($result = mysqli_fetch_array($query)) {
                                $namabarang = $result['nama_barang'];
                                $jumlah = $result['jumlah'];
                                $lama_sewa_start = $result['lama_sewa_start'];
                                $lama_sewa_end = $result['lama_sewa_end'];
                                $total_harga = $result['total_harga'];
                                $idPesanan = $result['idPesanan'];
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++; ?></th>
                                    <td><?php echo $namabarang; ?></td>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $lama_sewa_start; ?></td>
                                    <td><?php echo $lama_sewa_end; ?></td>
                                    <td><?php echo $total_harga; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="idPesanan" value="<?php echo $idPesanan; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>


    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#main-wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
