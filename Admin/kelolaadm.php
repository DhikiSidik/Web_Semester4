<?php
session_start();

if ($_SESSION["user_role"] != 3){
    echo"<script> alert ('Anda tidak memiliki ases pada halaman ini !!!');
            document.location.href = 'admin.php';
        </script>";
        exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="bootcatch sidebar is simple single page template with sidebar based on bootstrap, it's starter template for admin template - thanks :)">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></>
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
    .btn-tambah-barang {
        margin-top : 10px;
        margin-bottom: 10px;
        margin-left : 15px;
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
			  	<!-- end sidebar collapse button ## mobile view -->
			</nav>
			<!-- navbar ends -->
            <button type="button" class="btn btn-success btn-tambah-barang" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Tambah Admin
        </button>
            <div class="container-fluid">
            <div class="card-header text-white bg-dark text-lg-center">
                Daftar Admin
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">No Hp</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../koneksi.php";
                        $sql = "SELECT `id`, `email`, `nama`, `username`, `no_hp`,`alamat`, `jns_klmn`, `tgl` FROM `user` WHERE role = 1 ORDER BY nama ASC;";
                        $query = mysqli_query($koneksi, $sql);
                        $urut = 1;
                        while ($result = mysqli_fetch_array($query)) {
                            $nama       = $result ['nama'];
                            $username   = $result ['username'];
                            $email      = $result ['email'];
                            $no_hp      = $result ['no_hp'];
                            $jns      = $result ['jns_klmn'];
                            $tgl      = $result ['tgl'];
                            $alamat     = $result ['alamat']
                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++; ?></th>
                            <td scope="row"><?php echo $nama; ?></td>
                            <td scope="row"><?php echo $username; ?></td>
                            <td scope="row"><?php echo $email; ?></td>
                            <td scope="row"><?php echo $no_hp; ?></td>
                            <td scope="row"><?php echo $jns; ?></td>
                            <td scope="row"><?php echo $tgl; ?></td>
                            <td scope="row"><?php echo $alamat; ?></td>
                            <td scope="row">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editbarang<?= $urut ?>">
                                Ubah Informasi
                                </button>
                                <form action="proses.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="hapusadm" onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editbarang<?= $urut ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Edit Data Admin</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="proses.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                                        <div class="mb-3" id="hide-me">
                                            <label class="form-label">Id</label>
                                            <input type="text" class="form-control" name="id" value="<?php echo $result['id']?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama </label>
                                            <input type="text" class="form-control" name="nama" value="<?php echo $result['nama']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $result['username']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" value="<?= $result['email']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">No Hp</label>
                                            <input type="text" class="form-control" name="nohp" value="<?= $result['no_hp']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Jenis Kelamin</label>
                                            <div class="form-holder">
                                                <select name="jns" class="form-control">
                                                    <option <?php if($jns == 'Laki-Laki'){ echo "selected";}?> value="Laki-Laki" id="gender-2">Laki-laki</option>
                                                    <option <?php if($jns == 'Perempuan'){ echo "selected";}?> value="Perempuan" id="gender-1">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl" value="<?= $result['tgl']?>">
                                        </div><div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" value="<?= $result['alamat']?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" name="ubahadm">Simpan Perubahan</button>
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
                <div class="no-results" style="display: none; text-align: center; margin-top: 10px; color: red;">Nama atau Username tidak ditemukan</div>
            </div>
            </div>
        </div>
        <!-- modal tambah admin -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="proses.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Passord</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp</label>
                                <input type="text" maxlength="12" onkeypress="return validateNumber(event)" class="form-control" name="nohp" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Gender</label>
                                <div class="form-holder">
                                    <select name="gender" class="form-control">
                                        <option value="Lak-Laki" id="gender-2">Laki-laki</option>
                                        <option value="Perempuan" id="gender-1">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
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
