<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// function generatePDFReceipt($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga) {
function generatePDFReceipt($orders)
{
    require_once(__DIR__ . '/../TCPDF-main/tcpdf.php');
    
    // Create new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Hiktools');
    $orderId = $orders[0]['idPesanan']; // Get the order ID from the first order (assuming all orders have the same ID)
    $pdf->SetTitle('Struk pesanan - ID: ' . $orderId);
    $pdf->SetSubject('Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);
    $content = "<h1>Struk Pesanan</h1>";
    foreach ($orders as $order) {
               $content .= "
                
                <p>Pesanan ID: " . $order['idPesanan'] . "</p>
                <p>Nama Barang: " . htmlspecialchars($order['nama_barang']) . "</p>
                <p>Jumlah: " . $order['jumlah'] . "</p>
                <p>Tanggal Mulai Sewa: " . $order['lama_sewa_start'] . "</p>
                <p>Tanggal Akhir Sewa: " . $order['lama_sewa_end'] . "</p>
                <p>Total Harga: " . $order['total_harga'] . "</p>
                <br>
            ";
    }

    // Add content to the PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Save the PDF to a temporary file
    $tempFileName = tempnam(sys_get_temp_dir(), 'receipt');
    $pdf->Output($tempFileName, 'F');

    // Provide a download link for the user
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="receipt_order_id_' . $orderId . '.pdf"');
    readfile($tempFileName);

    // Clean up: delete the temporary file
    unlink($tempFileName);
}

// Display the order details in a table
function displayOrderDetails($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga)
{
    echo '
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Tanggal Mulai Sewa</th>
                    <th scope="col">Tanggal Akhir Sewa</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $orderId . '</td>
                    <td>' . $namaBarang . '</td>
                    <td>' . $jumlah . '</td>
                    <td>' . $lamaSewaStart . '</td>
                    <td>' . $lamaSewaEnd . '</td>
                    <td>' . $totalHarga . '</td>
                </tr>
            </tbody>
        </table>
    </div>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiktools - Struk Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Set the height to the full viewport height */
        }

        .table-container table {
            width: 80%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-container th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php
    // if (isset($_GET['order_id']) && isset($_GET['nama_barang']) && isset($_GET['jumlah']) && isset($_GET['lama_sewa_start']) && isset($_GET['lama_sewa_end']) && isset($_GET['total_harga'])) {
    if (isset($_GET['order_id'])) {
        $orderId = $_GET['order_id'];
        // $namaBarang = $_GET['nama_barang'];
        // $jumlah = $_GET['jumlah'];
        // $lamaSewaStart = $_GET['lama_sewa_start'];
        // $lamaSewaEnd = $_GET['lama_sewa_end'];
        // $totalHarga = $_GET['total_harga'];
        include '../koneksi.php';
        $sql = "SELECT *,(jumlah*total_harga) AS total_harga FROM sewa WHERE idPesanan = $orderId";
        $orders = mysqli_query($koneksi, $sql);
        $result=[];
        if (mysqli_num_rows($orders) > 0) {
            while ($row = mysqli_fetch_assoc($orders)) {
                $result[] = $row;
            }
        }


        // Generate and download the PDF receipt
        // generatePDFReceipt($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga);
        generatePDFReceipt($result);

        // Display the order details in a table
        // displayOrderDetails($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga);
    } else {
        echo '<p>No order details available.</p>';
    }
    ?>
</body>

</html>