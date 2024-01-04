<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['proses'])) {
        insertProduct();
    } elseif (isset($_POST['hapus'])) {
        deleteProduct();
    } elseif (isset($_POST['ubah'])) {
        updateProduct();
    } elseif (isset($_POST['tambah'])) {
        tambahadmin();
    } elseif (isset($_POST['hapusadm'])) {
        hapusadmin();
    } elseif (isset($_POST['ubahadm'])) {
        ubahadmin();
    } elseif (isset($_POST['ambil'])) {
        ambilbarang();
    } elseif (isset($_POST['hapuspsn'])) {
        hapuspesanan();
    } elseif (isset($_POST['kembali'])) {
        kembalibarang();
    } else {
        
    }
}


function insertProduct()
{
    include "../koneksi.php";
    if (isset($_POST['proses']) && isset($_FILES['gambar'])) {
        if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $barang = $_POST['barang'];
            $kat = $_POST['jns'];
            $stokk = $_POST['stokk'];
            $hargaa = $_POST['hargaa'];
    
            $Foto = $_FILES['gambar'];
            $nama_file = $_FILES['gambar']['name'];
            $ukuran_file = $_FILES['gambar']['size'];
            $tipe_file = $_FILES['gambar']['type'];
            $tmp_file = $_FILES['gambar']['tmp_name'];
            $path = "../ASSET/alat/" . $nama_file;
    
            if ($tipe_file == "image/jpeg" || $tipe_file == "image/png") {
                if ($ukuran_file <= 1000000) {
                    if (move_uploaded_file($tmp_file, $path)) {
                        $sql = "INSERT INTO barang (foto, nama_barang, idKategori, stok, harga) 
                                VALUES('$nama_file','$barang','$kat','$stokk','$hargaa')";
                        $query = mysqli_query($koneksi, $sql);
    
                        if ($query) {
                            header("Location: admin.php");
                            exit();
                        } else {
                            echo "Gagal mengunggah data ke database";
                        }
                    } else {
                        echo "Gagal upload";
                    }
                } else {
                    echo "Ukuran file lebih dari 1 MB";
                }
            } else {
                echo "Tipe file bukan image/jpeg atau image/png";
            }
        } else {
            echo "Gagal mengunggah file";
        }
    }else {
        echo "Gambar not found or form not submitted correctly.";
    }
}


function updateProduct()
{
    include "../koneksi.php";
    if (isset($_POST['ubah'])) {
        $stok = $_POST['stokkk'];
        $harga = $_POST['hargaaa'];
        $id = $_POST['id'];

        $sql = "UPDATE barang SET stok = '$stok', harga = '$harga'WHERE id = $id";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: admin.php");
            exit();
            } else {
                echo "Gagal mengunggah data ke database";
            }
        }
}

function deleteProduct(){
    include "../koneksi.php";
    if (isset($_POST['hapus'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM barang WHERE  id = $id";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: admin.php");
            exit();
            } else {
                echo "Gagal";
            }
        }
}

function tambahadmin(){
    include "../koneksi.php";
    if (isset($_POST['tambah'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['nohp'];
        $inputDate = $_POST['tgl'];
        $Password = $_POST['password'];
        $todayDate = date('Y-m-d');
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        $inputDateFormatted = date('Y-m-d', strtotime($inputDate));
                
        if ($inputDateFormatted >= $todayDate) {
            echo "<script>alert('Tanggal lahir harus sebelum hari ini!');</script>";
            echo "<script>{ window.location.href = 'kelolaadm.php'; };</script>";
        } else {

        $checkQuery = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' OR email = '$email' OR no_hp = '$phone'");
        if (mysqli_num_rows($checkQuery) > 0) {
            while ($row = mysqli_fetch_assoc($checkQuery)) {
                if ($row['username'] === $username) {
                    echo "<script>alert('Username sudah terdaftar!');</script>";
                } else if ($row['email'] === $email) {
                    echo "<script>alert('Email sudah terdaftar!');</script>";
                } else if ($row['no_hp'] === $phone) {
                    echo "<script>alert('No HP sudah terdaftar!');</script>";
                }
            }
            echo "<script>{ window.location.href = 'kelolaadm.php'; };</script>";
        } else {
            mysqli_query($koneksi, "INSERT INTO user SET
                email = '$_POST[email]',
                nama = '$_POST[nama]',
                username = '$_POST[username]',
                password = '$hashedPassword',
                no_hp = '$_POST[nohp]',
                jns_klmn = '$_POST[gender]',
                tgl = '$inputDateFormatted',
                alamat = '$_POST[alamat]',
                role = '1'");

            echo "<script>alert('Sukses');</script>";
            echo "<script>{ window.location.href = 'kelolaadm.php'; };</script>";
        }
    }
}
}

function hapusadmin(){
    include "../koneksi.php";
    if (isset($_POST['hapusadm'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM user WHERE  id = $id";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: kelolaadm.php");
            exit();
            } else {
                echo "Gagal";
            }
        }
    }

function ubahadmin(){
    include "../koneksi.php";
    if (isset($_POST['ubahadm'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $nohp = $_POST['nohp'];
        $jns = $_POST['jns'];
        $tgl = $_POST['tgl'];
        $alamat = $_POST['alamat'];

        $sql = "UPDATE user SET email = '$email', nama = '$nama', username = '$username', password = '$password', no_hp = '$nohp', jns_klmn = '$jns', tgl = '$tgl',
        alamat ='$alamat' WHERE id = $id";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: kelolaadm.php");
            exit();
            } else {
                echo "Gagal mengunggah data ke database";
            }
        }
    }

function ambilbarang()
{
    include "../koneksi.php";
    if (isset($_POST['ambil'])) {
        $id = $_POST['idPesanan'];

        $sql = "UPDATE pesanan SET status = 'diambil' WHERE idPesanan = $id;";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: pengambilan.php");
            exit();
            } else {
                echo "Gagal mengunggah data ke database";
            }
        }
}

function hapuspesanan(){
    include "../koneksi.php";
    if (isset($_POST['hapuspsn'])) {
        $id = $_POST['idPesanan'];

        $sql = "DELETE FROM pesanan WHERE  idPesanan = $id";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: pengambilan.php");
            exit();
            } else {
                echo "Gagal";
            }
        }
}

function kembalibarang()
{
    include "../koneksi.php";
    if (isset($_POST['kembali'])) {
        $id = $_POST['idPesanan'];

        $sql = "UPDATE pesanan SET status = 'done' WHERE idPesanan = $id;";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            header("Location: pengembalian.php");
            exit();
            } else {
                echo "Gagal mengunggah data ke database";
            }
        }
}
?>