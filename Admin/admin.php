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
    <title>Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://kit.fontawesome.com/9313f7f8f2.js" crossorigin="anonymous"></script>
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <style>
    .btn-tambah-barang {
        margin-top : 10px;
        margin-bottom: 10px;
        margin-left : 15px;
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
                const namaBarang = $(this).find("td:nth-child(3)").text().toLowerCase(); // Get the "Nama Barang" value from the third column
                const kategori = $(this).find("td:nth-child(4)").text().toLowerCase(); // Get the "Kategori" value from the fourth column

                if (namaBarang.indexOf(query) === -1 && kategori.indexOf(query) === -1) {
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

        $("input.form-control").keypress(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
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
            <button type="button" class="btn btn-success btn-tambah-barang" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Tambah Barang
        </button>
            <div class="container-fluid">
            <div class="card-header text-white bg-dark text-lg-center">
                Daftar Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Harga Sewa</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../koneksi.php";
                        $sql = "SELECT barang.id, barang.foto, barang.nama_barang, barang.stok, barang.harga, kategori.jenis AS kategori FROM barang, kategori WHERE barang.idkategori = kategori.id ORDER BY barang.nama_barang ASC;";
                        $query = mysqli_query($koneksi, $sql);
                        $urut = 1;
                        while ($result = mysqli_fetch_array($query)) {
                            $foto       = $result ['foto'];
                            $barang     = $result ['nama_barang'];
                            $stok       = $result ['stok'];
                            $harga      = $result ['harga'];
                            $kategori   = $result ['kategori']
                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++; ?></th>
                            <td scope="row"><img src="..\ASSET\alat\<?php echo $foto; ?>" width="100" height="100""></td>
                            <td scope="row"><?php echo $barang; ?></td>
                            <td scope="row"><?php echo $kategori; ?></td>
                            <td scope="row"><?php echo $stok; ?></td>
                            <td scope="row">Rp. <?php echo $harga; ?></td>
                            <td scope="row">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editbarang<?= $urut ?>">
                                Ubah Stok/Harga
                                </button>
                                <form action="proses.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="hapus" onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editbarang<?= $urut ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Edit Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="proses.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                                        <div class="mb-3" id="hide-me">
                                            <label class="form-label">Id</label>
                                            <input type="text" class="form-control" name="id" value="<?php echo $result['id']?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control" name="barangg" value="<?php echo $result['nama_barang']?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="text" class="form-control" name="stokkk" value="<?= $result['stok']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Harga</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control" name="hargaaa" value="<?= $result['harga']?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" name="ubah">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="no-results" style="display: none; text-align: center; margin-top: 10px; color: red;">Barang tidak ditemukan</div>
            </div>
            </div>
        </div>
        <!-- /#main-content -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="proses.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="gambar">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="barang">
                            </div>
                            <div class="mb-3">
                                <label for="">Kategori:</label>
                                <div class="form-holder">
                                    <select name="jns" class="form-control">
                                        <option value="2" id="jns-2">Tenda</option>
                                        <option value="1" id="jns-1">Tas Punggung</option>
                                        <option value="3" id="jns-3">Perkakas Masak</option>
                                        <option value="4" id="jns-4">Peralatan Tidur</option>
                                        <option value="5" id="jns-5">Pakaian</option>
                                        <option value="6" id="jns-6">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="text" class="form-control" name="stokk">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" name="hargaa">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" name="proses">Simpan</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#main-wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
