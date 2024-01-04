<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Daftar Akun</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/9313f7f8f2.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/daftar/style.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="js/script.js"></script>
	</head>

	<body>
		<div class="wrapper" style="background-image: url('ASSET/bg1.jpeg');">
			<div class="inner">
				<form name="updateForm" action="" method="POST" autocomplete="off">
					<h3>Registration Form</h3>
					<div class="form-group">
						<div class="form-wrapper">
							<label for="">Nama:</label>
							<div class="form-holder">
								<i class="fa-solid fa-user"></i>
								<input type="text" name="nama" autofocus class="form-control" required>
							</div>
						</div>
						<div class="form-wrapper">
							<label for="">Username:</label>
							<div class="form-holder">
								<i class="fa-solid fa-user"></i>
								<input type="text" name="user" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-wrapper">
							<label for="">Email:</label>
							<div class="form-holder">
								<i class="fa-solid fa-envelope"></i>
								<input type="email" name="email" class="form-control" required>
							</div>
						</div>
						<div class="form-wrapper">
							<label for="">Password:</label>
							<div class="form-holder">
								<i class="fa-solid fa-lock"></i>
								<input type="password" name="password" class="form-control" placeholder="********" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-wrapper">
							<label for="">No hp:</label>
							<div class="form-holder">
								<i class="fa-solid fa-mobile"></i>
								<input type="text" name="hp" maxlength="12" onkeypress="return validateNumber(event)" class="form-control" required>
							</div>
						</div>
						<div class="form-wrapper">
							<label for="">Gender:</label>
							<div class="form-holder">
								<select name="jkl" class="form-control">
									<option  value="Laki-laki" id="jkl-laki">Laki-laki</option>
									<option value="Perempuan" id="jkl-perempun">Perempuan</option>
								</select>
								<i class="fa-solid fa-venus-mars"></i>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="form-wrapper">
							<label for="">Tanggal lahir:</label>
							<div class="form-holder">
								<i class="fa-sharp fa-solid fa-calendar-days"></i>
								<input type="date" name="lahir" class="form-control" required>
							</div>
						</div>
						<div class="form-wrapper">
							<label for="">Alamat:</label>
							<div class="form-holder">
								<i class="fa-solid fa-location-dot"></i>
								<textarea name="alamat" id="" cols="30" rows="10" class="form-control" required></textarea>
							</div>
						</div>
					</div>
					<div class="form-end">
						<div class="button-holder">
							<button type="submit" value="Submit" name="proses" style="float: right;">Register Now</button>
						</div>
					</div>
                    <p style="text-align: center; margin-top: 30px;">Already have an account? <a href="login.php">Login here</a></p>
				</form>
			</div>
		</div>

        <?php
		include "koneksi.php";

		if (isset($_POST['proses'])) {
			$username = $_POST['user'];
			$email = $_POST['email'];
			$phone = $_POST['hp'];
			$inputDate = $_POST['lahir'];
			$todayDate = date('Y-m-d');
			$password = $_POST['password'];
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$inputDateFormatted = date('Y-m-d', strtotime($inputDate));

			if ($inputDateFormatted >= $todayDate) {
				echo "<script>showErrorAlert('Tanggal lahir Tidak Sesuai !');</script>";
			} else {
				$checkQuery = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' OR email = '$email' OR no_hp = '$phone'");
				$checkResult = mysqli_fetch_assoc($checkQuery);

				if ($checkResult) {
					if ($checkResult['username'] === $username) {
						echo "<script>showErrorAlert('Username sudah terdaftar!');</script>";
					} else if ($checkResult['email'] === $email) {
						echo "<script>showErrorAlert('Email sudah terdaftar!');</script>";
					} else if ($checkResult['no_hp'] === $phone) {
						echo "<script>showErrorAlert('No HP sudah terdaftar!');</script>";
					}
				} else {
					mysqli_query($koneksi, "INSERT INTO user SET
						email = '$_POST[email]',
						nama = '$_POST[nama]',
						username = '$_POST[user]',
						password = '$hashedPassword',
						no_hp = '$_POST[hp]',
						jns_klmn = '$_POST[jkl]',
						tgl = '$inputDateFormatted',
						alamat = '$_POST[alamat]',
						role = '2'");
					echo "<script>showSuccessAlert('Sukses');</script>";
					echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 2000);</script>";
				}
			}
		}
		?>
	</body>
</html>
