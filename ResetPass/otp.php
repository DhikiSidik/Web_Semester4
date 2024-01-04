<?php
$email = $_GET['email'];

require_once '../koneksi.php';
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$sql = "SELECT kode FROM user WHERE email = '$email'";

// Menjalankan query
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    // Mengambil data hasil query
    while ($row = $result->fetch_assoc()) {
        $kode = $row['kode'];
        if (isset($_POST['kode_input']) && $kode == $_POST['kode_input']) {
            header("Location: newpass.php?email=" . urlencode($email));
            exit();
        }
    }
} else {
    echo "Tidak ada hasil yang ditemukan";
}
$koneksi->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<style>
    html, body {
        height: 100%;
    }

    body {
        background-image: url("../ASSET/bg1.jpeg");
        background-size: cover;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .card {
        width: 500px;
        margin-bottom: 50px;
    }
</style>
    <title>OTP</title>
</head>
<body>
    <div class="container">
        <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5>Verifikasi Email</h5>
        </div>
        <div class="card-body">
            <p class="card-text">
            Silakan masukkan kode verifikasi yang dikirim ke email
            </p>
            <form action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Kode Verifikasi :</label>
                <input type="text" name="kode_input" class="form-control" id="otp" placeholder="Masukkan Kode">
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Verifikasi</button>
            </form>
            <div class="text-center mt-3">
            <a href="../login.php">Batal</a>
            </div>
        </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>