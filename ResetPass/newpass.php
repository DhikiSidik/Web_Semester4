<?php
$email = $_GET['email'];

require_once '../koneksi.php';

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['submit'])) {
    $newPassword = $_POST['new_password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateSql = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";
    if ($koneksi->query($updateSql) === true) {
        header("Location: ../login.php");
        exit();
    } else {
        echo "Gagal memperbarui password: " . $koneksi->error;
    }
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
    <title>Password Reset</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h5>Password Reset</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Silahkan ganti password anda
                </p>
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Password Baru</label>
                        <input type="text" name="new_password" class="form-control" id="email" placeholder="Password Baru">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
                <div class="text-center mt-3">
                    <a href="../login.php">Login</a> | <a href="../daftar.php">Register</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

