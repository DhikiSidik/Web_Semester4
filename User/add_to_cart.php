<?php
include '../koneksi.php';
// Start the session
session_start();

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the quantity field exists in the POST data
    if (isset($_POST['quantity'])) {
        // Get the value of the quantity field and sanitize it (optional, depending on your validation needs)
        $quantity = intval($_POST['quantity']);

        // Example data (replace this with your actual data from the form or database)
        $namaBarang = $_POST['namaBarang'];

        // Fetch the price ($harga) and idBarang from the "barang" table based on the provided $namaBarang
        $sql_get_barang_data = "SELECT id, harga FROM barang WHERE nama_barang = ?";
        $stmt_get_barang_data = $koneksi->prepare($sql_get_barang_data);
        $stmt_get_barang_data->bind_param("s", $namaBarang);
        $stmt_get_barang_data->execute();
        $result_get_barang_data = $stmt_get_barang_data->get_result();

        // Check if the item exists in the "barang" table
        if ($result_get_barang_data->num_rows > 0) {
            // Get the data of the item
            $row = $result_get_barang_data->fetch_assoc();
            $idBarang = $row['id'];
            $harga = $row['harga'];

            // Check if the cart exists in the session
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; // Initialize the cart as an empty array if it doesn't exist
            }

            // Assuming you have a session variable for the logged-in user ID
            $idUser = $_SESSION['user_id'];

            // Check if the item is already in the cart for the specific user
            $sql_check_cart = "SELECT * FROM keranjang WHERE idUser = ? AND nama_barang = ?";
            $stmt_check_cart = $koneksi->prepare($sql_check_cart);
            $stmt_check_cart->bind_param("is", $idUser, $namaBarang);
            $stmt_check_cart->execute();
            $result_check_cart = $stmt_check_cart->get_result();

            if ($result_check_cart->num_rows > 0) {
                // If the item already exists, update the quantity
                $sql_update_cart = "UPDATE keranjang SET jumlah = jumlah + ? WHERE idUser = ? AND nama_barang = ?";
                $stmt_update_cart = $koneksi->prepare($sql_update_cart);
                $stmt_update_cart->bind_param("iis", $quantity, $idUser, $namaBarang);
                $stmt_update_cart->execute();
            } else {
                // If the item is not in the cart, add it as a new item
                $sub_total = $harga * $quantity; // Calculate the subtotal based on the product price and quantity
                $sql_insert_cart = "INSERT INTO keranjang (idUser, idBarang, nama_barang, jumlah, sub_total) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert_cart = $koneksi->prepare($sql_insert_cart);
                $stmt_insert_cart->bind_param("iisid", $idUser, $idBarang, $namaBarang, $quantity, $sub_total);
                $stmt_insert_cart->execute();
            }

            // For simplicity, assume the item is added successfully and return "success" to the AJAX request
            echo "success";
        } else {
            // Item not found in the "barang" table
            echo "Error: Item not found.";
        }
    } else {
        // If the quantity field is not set in the POST data, return an error message
        echo "Error: Quantity field is missing.";
    }
} else {
    // If the request is not a POST request, return an error message
    echo "Error: Invalid request method.";
}
?>
