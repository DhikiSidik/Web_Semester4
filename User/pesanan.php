<?php
session_start();
include '../koneksi.php';

// Function to get the order count from the server
function getOrderCount() {
    include '../koneksi.php';
    if (isset($_SESSION['user_id'])) {
        $idUser = $_SESSION['user_id'];
        $queryCount = "SELECT COUNT(*) as total FROM sewa WHERE idUser = $idUser";
        $resultCount = mysqli_query($koneksi, $queryCount);
        $row = mysqli_fetch_assoc($resultCount);
        return $row['total'];
    } else {
        return 0;
    }
}

// Function to get orders for the current user
function getOrders() {
    include '../koneksi.php';
    if (isset($_SESSION['user_id'])) {
        $idUser = $_SESSION['user_id'];
        $queryOrders = "
            SELECT 
                p.idPesanan,
                ts.id,
                ts.idBarang,
                b.nama_barang,
                CONCAT('../ASSET/alat/', b.foto) AS foto,
                ts.jumlah,
                ts.lama_sewa_start,
                ts.lama_sewa_end,
                (b.harga * ts.jumlah) AS total_harga 
            FROM sewa ts
            JOIN barang b ON ts.idBarang = b.id 
            JOIN pesanan p ON ts.idPesanan = p.idPesanan
            WHERE p.idUser = $idUser
            GROUP BY p.idPesanan, ts.idBarang, b.nama_barang, ts.lama_sewa_start, ts.lama_sewa_end
        ";
        $resultOrders = mysqli_query($koneksi, $queryOrders);
        return $resultOrders;
    } else {
        return null;
    }
}




?>

<!DOCTYPE html>
<html>
<head>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hiktools</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="keranjang.php">Keranjang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add any other CSS styles specific to your page -->
    <link rel="stylesheet" href="styleUser.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <!-- Navbar content -->
    <!-- ... -->
</nav>

<!-- ... (your existing code) ... -->
<div class="container mt-4">
    <h2>Daftar Pesanan Anda</h2>
    <?php
    $orders = getOrders();
    $currentOrderId = null; 
    if (mysqli_num_rows($orders) > 0) {
        while ($order = mysqli_fetch_assoc($orders)) {
            if ($currentOrderId !== $order['idPesanan']) {
                // Close the previous card if there was one
                if ($currentOrderId !== null) {
                    echo '</div>'; // Close the card-body div
                    echo '<div class="card-footer">'; // Start the card-footer div
                    echo '
                        <div class="col-md-4">
                            <a href="javascript:void(0)" class="btn btn-primary download-btn" onclick="generateReceipt(\'' . $currentOrderId . '\', \'' . $currentNamaBarang . '\', \'' . $currentJumlah . '\', \'' . $currentLamaSewaStart . '\', \'' . $currentLamaSewaEnd . '\', \'' . $currentTotalHarga . '\')">Unduh Struk</a>
                        </div>
                        </div>
                    '; // Close the card-footer div
                    echo '</div>'; // Close the card div
                }
                // Start a new card for each unique idPesanan
                $currentOrderId = $order['idPesanan'];
                $currentNamaBarang = $order['nama_barang'];
                $currentJumlah = $order['jumlah'];
                $currentLamaSewaStart = $order['lama_sewa_start'];
                $currentLamaSewaEnd = $order['lama_sewa_end'];
                $currentTotalHarga = $order['total_harga'];
                ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Pesanan ID: <?php echo $order['idPesanan']; ?></strong>
                    </div>
                    <div class="card-body">
                <?php
            }
            ?>
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo $order['foto']; ?>" alt="Foto Barang" class="img-fluid">
                </div>
                <div class="col-md-9">
                <p>Nama Barang: <?php echo $order['nama_barang']; ?></p>
                <p>Jumlah: <?php echo $order['jumlah']; ?></p>
                <p>Tanggal Mulai Sewa: <?php echo $order['lama_sewa_start']; ?></p>
                <p>Tanggal Akhir Sewa: <?php echo $order['lama_sewa_end']; ?></p>
                <p>Total Harga: <?php echo $order['total_harga']; ?></p>
            </div>
            </div>
            <?php
        }
        // Close the last card if there was one
        echo '</div>'; // Close the card-body div
        echo '</div>'; // Close the card-body div
        echo '<div class="card-footer">
        <div class="col-md-4">
        
        <a href="javascript:void(0)" class="btn btn-primary download-btn" onclick="generateReceipt(\'' . $currentOrderId . '\', \'' . $currentNamaBarang . '\', \'' . $currentJumlah . '\', \'' . $currentLamaSewaStart . '\', \'' . $currentLamaSewaEnd . '\', \'' . $currentTotalHarga . '\')">Unduh Struk</a>
    </div>
    </div>
    </div>
    
        '; // Start the card-footer div
        echo '</div>'; // Close the card div
       
        
    } else {
        echo '<p>Tidak ada pesanan.</p>';
    }
    ?>
</div>
<!-- ... (rest of your code) ... -->


<!-- Add any JavaScript scripts specific to your page -->
</body>


<script>
    // JavaScript function to automatically download the PDF receipt
    function generateReceipt(orderId, namaBarang, jumlah, lamaSewaStart, lamaSewaEnd, totalHarga) {
        // Create a temporary link element
        var link = document.createElement('a');
        // link.href = `generate_receipt.php?order_id=${orderId}&nama_barang=${namaBarang}&jumlah=${jumlah}&lama_sewa_start=${lamaSewaStart}&lama_sewa_end=${lamaSewaEnd}&total_harga=${totalHarga}`;
        link.href = `generate_receipt.php?order_id=${orderId}`;
        link.target = '_blank'; // Open the link in a new tab
        link.download = `receipt_order_id_${orderId}.pdf`; // Set the suggested file name

        // Append the link to the document and simulate a click on it
        document.body.appendChild(link);
        link.click();

        // Clean up: remove the link from the document
        document.body.removeChild(link);
    }
</script>
<?php

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include the Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
       function removeOrder(orderId) {
        console.log('Removing order with ID:', orderId);
        if (confirm("Apakah Anda yakin ingin menghapus pesanan ini?")) {
            // Send an AJAX request to delete.php to delete the order
            $.ajax({
                type: 'GET',
                url: 'delete_order.php', // Update this URL to 'delete.php'
                data: { order_id: orderId },
                dataType: 'json',
                success: function (data) {
                    if (data.status === 'success') {
                        // If the order is successfully deleted, reload the page to update the order list
                        location.reload();
                    } else {
                        // If there is an error, display an error message or handle it as needed
                        alert('Gagal menghapus pesanan.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

</html>
