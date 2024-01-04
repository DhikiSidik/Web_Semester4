<?php
require '../koneksi.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$randomCode = "";
$email = "";
$errorMessage = "";

if (isset($_POST['send'])) {
    $email = $_POST["email"];

    $cekEmailQuery = "SELECT * FROM `user` WHERE `email` = '$email'";
    $result = $koneksi->query($cekEmailQuery);

    if ($result->num_rows > 0) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'farefun312@gmail.com';
        $mail->Password = 'pavfvqjztvdlgygp';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('Peminjaman@gmail.com');

        $mail->addAddress($email);

        $mail->isHTML(true);

        $randomCode = generateRandomCode();

        $mail->Subject = "Kode Verifikasi";

        $mail->Body = "Berikut adalah kode Verifikasi anda: " . $randomCode;

        if ($mail->send()) {
            $sql = "UPDATE `user` SET `kode`='$randomCode' WHERE `email` = '$email'";
        
            if ($koneksi->query($sql) === TRUE) {
                header("Location: otp.php?email=" . urlencode($email));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }
        } else {
            echo "Mail sending failed: " . $mail->ErrorInfo;
        }
    } else {
        echo "
            <script>
                alert('Email tidak ditemukan di database. Silakan cek kembali email yang Anda masukkan.');
                window.history.back();
            </script>
            ";
    }
}

function generateRandomCode()
{
    $characters = '0123456789';
    $codeLength = 6;
    $randomCode = '';

    for ($i = 0; $i < $codeLength; $i++) {
        $randomCode .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomCode;
}
?>
