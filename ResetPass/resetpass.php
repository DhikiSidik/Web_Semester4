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
            Masukkan alamat email Anda dan kami akan mengirimkan email berisi kode untuk mereset kata sandi Anda.  
            </p>
            <form action="send.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Alamat Email :</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email">
            </div>
            <button type="submit" name="send" class="btn btn-primary btn-block">Reset Password</button>
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
