<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
    // Escape and get the value of order_id from the URL parameter
    $orderId = mysqli_real_escape_string($koneksi, $_GET['order_id']);

    // Get the current user's ID from the session
    $idUser = $_SESSION['user_id'];

    // Perform additional validation as needed, e.g., check if the order belongs to the user who is allowed to delete it

    // Delete the order from the database
    $queryDeleteOrder = "DELETE FROM sewa WHERE idPesanan = '$orderId' AND idUser = '$idUser'";
    $resultDeleteOrder = mysqli_query($koneksi, $queryDeleteOrder);

    if ($resultDeleteOrder) {
        // If the deletion is successful, send a JSON response indicating success
        echo json_encode(array('status' => 'success'));
        exit;
    } else {
        // If there's an error during deletion, send a JSON response indicating failure
        echo json_encode(array('status' => 'error'));
        exit;
    }
} else {
    // If the order_id parameter is not present or valid, or the request method is not GET, return to the previous page
    header("Location: pesanan.php");
    exit;
}


?>
