<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function generatePDFReceipt($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga) {

    require_once('/../TCPDF-main/tcpdf.php');

    // Create new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Hiktools');
    $pdf->SetTitle('Receipt - Order ID: ' . $orderId);
    $pdf->SetSubject('Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);

    // Add content to the PDF
    $content = "
        <h2>Struk Pesanan</h2>
        <p>Pesanan ID: $orderId</p>
        <p>Nama Barang: $namaBarang</p>
        <p>Jumlah: $jumlah</p>
        <p>Tanggal Mulai Sewa: $lamaSewaStart</p>
        <p>Tanggal Akhir Sewa: $lamaSewaEnd</p>
        <p>Total Harga: $totalHarga</p>
    ";
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output the PDF to the browser for download
    $file_name = 'receipt_order_id_' . $orderId . '.pdf';
    $pdf->Output($file_name, 'D');

    // Clean the output buffer
    ob_end_clean();

    // Additional debug logging
   
}

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
<?php
if (isset($_GET['order_id']) && isset($_GET['nama_barang']) && isset($_GET['jumlah']) && isset($_GET['lama_sewa_start']) && isset($_GET['lama_sewa_end']) && isset($_GET['total_harga'])) {
    $orderId = $_GET['order_id'];
    $namaBarang = $_GET['nama_barang'];
    $jumlah = $_GET['jumlah'];
    $lamaSewaStart = $_GET['lama_sewa_start'];
    $lamaSewaEnd = $_GET['lama_sewa_end'];
    $totalHarga = $_GET['total_harga'];

    // Generate and download the PDF receipt
    generatePDFReceipt($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga);

    // Display the order details in a table
    displayOrderDetails($orderId, $namaBarang, $jumlah, $lamaSewaStart, $lamaSewaEnd, $totalHarga);
} else {
    echo '<p>No order details available.</p>';
}
?>