<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['selected_items']) && isset($_POST['tanggal_mulai']) && isset($_POST['tanggal_berakhir'])) {
        $selectedItems = $_POST['selected_items'];
        $tanggalMulai = $_POST['tanggal_mulai'];
        $tanggalBerakhir = $_POST['tanggal_berakhir'];
        $idUser = $_SESSION['user_id'];

        if (empty($selectedItems)) {
            echo json_encode(['status' => 'error', 'message' => 'No items selected']);
            exit;
        }

        // Check if the requested quantity exceeds the available stock
        $queryStockCheck = "SELECT SUM(jumlah) AS total_jumlah FROM keranjang WHERE id IN ($selectedItems)";
        $resultStockCheck = mysqli_query($koneksi, $queryStockCheck);
        $rowStockCheck = mysqli_fetch_assoc($resultStockCheck);
        $requestedQuantity = (int)$rowStockCheck['total_jumlah'];

        // Retrieve the available stock for each item in the cart
        $queryStockAvailable = "SELECT id, stok FROM barang WHERE id IN (SELECT idBarang FROM keranjang WHERE id IN ($selectedItems))";
        $resultStockAvailable = mysqli_query($koneksi, $queryStockAvailable);
        $stockAvailableMap = array();
        while ($rowStockAvailable = mysqli_fetch_assoc($resultStockAvailable)) {
            $stockAvailableMap[$rowStockAvailable['id']] = (int)$rowStockAvailable['stok'];
        }

        foreach ($stockAvailableMap as $idBarang => $stockAvailable) {
            $queryStockUpdate = "UPDATE barang SET stok = stok - $requestedQuantity WHERE id = $idBarang AND stok >= $requestedQuantity";
            $resultStockUpdate = mysqli_query($koneksi, $queryStockUpdate);

            if (!$resultStockUpdate) {
                echo json_encode(['status' => 'error', 'message' => 'Insufficient stock for some items']);
                exit;
            }
        }
        // Process the checkout and insert data into the 'pesanan' table
$queryCheckout = "INSERT INTO pesanan (idUser, tanggalPesan, totalHarga)
VALUES ($idUser, NOW(), (SELECT SUM(sub_total) FROM keranjang WHERE id IN ($selectedItems)))";
$resultCheckout = mysqli_query($koneksi, $queryCheckout);

if ($resultCheckout) {
// Get the newly generated order ID
$orderId = mysqli_insert_id($koneksi);

// Insert the grouped order details into the 'sewa' table using the order ID
$queryInsertSewa = "INSERT INTO sewa (idUser,idPesanan, idBarang, nama_barang, jumlah, lama_sewa_start, lama_sewa_end, total_harga)
    SELECT $idUser,$orderId, idBarang, nama_barang, jumlah, '$tanggalMulai', '$tanggalBerakhir', sub_total 
    FROM keranjang WHERE id IN ($selectedItems)";
$resultInsertSewa = mysqli_query($koneksi, $queryInsertSewa);

if ($resultInsertSewa) {
// Checkout successful, remove selected items from the cart
$queryDelete = "DELETE FROM keranjang WHERE id IN ($selectedItems)";
$resultDelete = mysqli_query($koneksi, $queryDelete);

if ($resultDelete) {
    header("Location: keranjang.php");
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove items from the cart']);
    exit;
}
} else {
echo json_encode(['status' => 'error', 'message' => 'Failed to process the checkout']);
exit;
}
} else {
echo json_encode(['status' => 'error', 'message' => 'Failed to process the checkout']);
exit;
}


        if ($resultCheckout) {
            // Checkout successful, remove selected items from the cart
            $queryDelete = "DELETE FROM keranjang WHERE id IN ($selectedItems)";
            $resultDelete = mysqli_query($koneksi, $queryDelete);

            if ($resultDelete) {
                header("Location: keranjang.php");
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to remove items from the cart']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to process the checkout']);
            exit;
        }
    } else {
        // Handle invalid request method (redirect to an error page or show an error message)
        header("Location: keranjang.php");
        exit;
    }
}
?>
