<!doctype html>
<html lang="en">
<head>
    <title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login/style.css">
    <script src="js/script.js"></script>
</head>
<body class="img js-fullheight" style="background-image: url(ASSET/bg.jpg);">
    <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Login</h2>
        </div>
        </div>
        <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
            <h3 class="mb-4 text-center">Have an account?</h3>
            <form action="#" method="POST" class="signin-form" autocomplete="off">
                <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                <input id="password-field" name="password" type="password" class="form-control" placeholder="Password" required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                <button type="submit" value="Login" class="form-control btn btn-primary submit px-3">Sign In</button>
                </div>
                <div class="form-group text-center">
                    <a href="ResetPass/resetpass.php" style="color: #fff">Forgot Password</a>
                </div>
                <div class="form-group text-center">
                    <a href="daftar.php" style="color: #fff">Create Account</a>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </section>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <?php
    session_start();
    require_once 'koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $username = mysqli_real_escape_string($koneksi, $username);

        $sql = "SELECT id, username, password, role FROM user WHERE username='$username'";
        $result = mysqli_query($koneksi, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDatabase = $row["password"];

            if (password_verify($password, $hashedPasswordFromDatabase)) {
                $_SESSION["user_id"] = $row['id'];
                $_SESSION["user_role"] = $row['role'];

                if ($row["role"] == 2) {
                    header("location: User/user.php");
                } elseif ($row["role"] == 1) {
                    header("location: Admin/admin.php");
                } elseif ($row["role"] == 3) {
                    header("location: Admin/admin.php");
                } else {
                    echo "<script>showErrorAlert('Terjadi Kesalahan');</script>";
                }
                exit();
            } else {
                echo "<script>showErrorAlert('Username atau password salah');</script>";
            }
        } else {
            echo "<script>showErrorAlert('Username atau password salah');</script>";
        }
    }
    ?>
</body>
</html>
