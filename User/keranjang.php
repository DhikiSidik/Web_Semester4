<?php
session_start();
include '../koneksi.php';

function getCountKeranjang($idUser)
{
    include '../koneksi.php';
    $queryCount = "SELECT COUNT(*) as total FROM keranjang WHERE idUser = $idUser";
    $resultCount = mysqli_query($koneksi, $queryCount);
    $row = mysqli_fetch_assoc($resultCount);
    return $row['total'];
}

if (isset($_POST['action']) && $_POST['action'] == 'update_quantity') {
    // Handle AJAX request to update item quantity in the cart
    $itemId = $_POST['item_id'];
    $newQuantity = (int)$_POST['new_quantity'];

    // Perform any validation checks for the new quantity if needed

    $queryUpdateQuantity = "UPDATE keranjang SET jumlah = $newQuantity WHERE id = $itemId";
    $resultUpdateQuantity = mysqli_query($koneksi, $queryUpdateQuantity);

    if ($resultUpdateQuantity) {
        // Respond to the client-side AJAX request
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        echo json_encode(['status' => 'error']);
        exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'remove_item') {
    // Handle AJAX request to remove item from the cart
    $itemId = $_POST['item_id'];
    $queryDelete = "DELETE FROM keranjang WHERE id = $itemId";
    $resultDelete = mysqli_query($koneksi, $queryDelete);

    if ($resultDelete) {
        // Respond to the client-side AJAX request
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        echo json_encode(['status' => 'error']);
        exit;
    }
}

$idUser = $_SESSION['user_id'];
$jumlahBarangKeranjang = getCountKeranjang($idUser);

$query = "SELECT k.*, CONCAT('../ASSET/alat/', foto) AS foto FROM keranjang k
          JOIN barang b ON k.idBarang = b.id
          WHERE k.idUser = $idUser";

$result = mysqli_query($koneksi, $query);

$totalPrice = 0;
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
                        <a class="nav-link active" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <div class="search-bar">
                        <form class="form-inline" onsubmit="return false;">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="performSearch()">Search</button>
                        </form>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Include your CSS and other necessary scripts here -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .form-check {
            position: absolute;
            top: 35%;
            left: 50px;
            color: green;
        }

        .select-all-checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .select-all-checkbox-container label {
            margin-left: 5px;
        }

        .checkout-btn {
            margin-top: 10px;
            margin-left: 10px;
            align-items: center;

        }

        footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }

        #checkout-form {
            width: 100%;
        }

        .col-md-4 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .select-all-checkbox-container {
            display: flex;
            margin-left: 60px;
        }

        .search-bar {
            position: absolute;
            width: 100%;
            left: 35%;
            padding: 30px;
            margin-left: 350px;
        }

        #checkout-form {
            margin-top: 60px;
        }

        #searchInput {
            width: 30%;
        }
        
    </style>
</head>

<body>
    <div class="header">
        <h2>Keranjang Belanja</h2>
    </div>

    <form id="checkout-form">
        <div class="select-all-checkbox-container">
            <input class="form-check-input select-all-checkbox" type="checkbox">
            <label class="form-check-label">Select All</label>
        </div>
        <div class="cart-items">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($item = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-1">
                                <!-- Add the checkbox for each cart item -->
                                <div class="form-check">
                                    <input class="form-check-input item-checkbox" type="checkbox" value="<?php echo $item['id']; ?>" data-price="<?php echo $item['sub_total']; ?>" data-quantity="<?php echo $item['jumlah']; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Display item image or other information here -->
                                <img src="<?php echo $item['foto']; ?>" width="100" height="100">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['nama_barang']; ?></h5>
                                    <p class="card-text">Jumlah: <?php echo $item['jumlah']; ?></p>
                                    <p class="card-text">Sub Total: <?php echo $item['sub_total'] * $item['jumlah']; ?></p>
                                    <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editQuantityModal" data-item-id="<?php echo $item['id']; ?>" data-item-quantity="<?php echo $item['jumlah']; ?>">Edit Jumlah</button>
                                </div>
                            </div>
                            <!-- Edit Quantity Modal -->
                            <div class="modal fade" id="editQuantityModal" tabindex="-1" role="dialog" aria-labelledby="editQuantityModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editQuantityModalLabel">Edit Jumlah Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editQuantityForm">
                                                <div class="form-group">
                                                    <label for="new_quantity">Jumlah Baru</label>
                                                    <input type="number" class="form-control" id="new_quantity" name="new_quantity">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-primary" id="saveQuantityBtn">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-danger remove-btn" onclick="removeFromCart('<?php echo $item['id']; ?>')">Hapus</button>
                            </div>

                        </div>
                    </div>
                <?php
                    $totalPrice += $item['sub_total'] * $item['jumlah'];
                }
            } else {
                ?>
                <p>Keranjang belanja kosong.</p>
            <?php
            }

            ?>
        </div>

        <div class="total-price">
            Total: $<span id="total-price"><?php echo $totalPrice ; ?></span>
        </div>
        <!-- Modify the "Checkout" button to open the checkout modal -->
        <button type="button" class="btn btn-primary checkout-btn" data-toggle="modal" data-target="#checkoutModal">Checkout</button>


    </form>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Form Checkout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="checkoutForm" method="POST" action="proses_checkout.php">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai Sewa</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_berakhir">Tanggal Berakhir Sewa</label>
                            <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                        </div>
                        <!-- Add a hidden input field to store the selected item IDs -->
                        <input type="hidden" id="selected_items" name="selected_items" value="">
                    </form>
                    <!-- Display the selected items here -->
                    <div id="selected_items_display"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="checkoutBtn">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to remove item from the cart
        function removeFromCart(itemId) {
            // Implement the logic to remove the item from the cart
            console.log("Removing item:", itemId);
            $.ajax({
                type: "POST",
                url: "keranjang.php",
                data: {
                    action: "remove_item",
                    item_id: itemId
                },
                success: function(data) {
                    // If the item is successfully removed, reload the page to update the cart
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function calculateTotalPrice() {
            let totalPrice = 0;
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            const selectedItems = [];

            checkboxes.forEach((checkbox) => {
                // Push the selected item ID to the array
                selectedItems.push(checkbox.value);

                const itemPrice = parseFloat(checkbox.getAttribute('data-price'));
                const itemQuantity = parseInt(checkbox.getAttribute('data-quantity'));
                const itemSubtotal = itemPrice * itemQuantity;
                totalPrice += itemSubtotal;
            });

            // Store the selected item IDs in the hidden input field
            document.getElementById('selected_items').value = selectedItems.join(',');

            // Update the total price element
            const totalPriceElement = document.getElementById('total-price');
            totalPriceElement.innerText = totalPrice.toFixed(2);
        }

        // Attach the calculateTotalPrice function to the change event of the checkboxes
        document.querySelectorAll('.item-checkbox').forEach((checkbox) => {
            checkbox.addEventListener('change', calculateTotalPrice);
        });
        $(document).ready(function() {
            // Handle "Select All" checkbox click event
            $('.select-all-checkbox').click(function() {
                const isChecked = $(this).prop('checked');
                $('.item-checkbox').prop('checked', isChecked);
                calculateTotalPrice();
            });

            // Handle item checkbox click event
            $('.item-checkbox').click(function() {
                calculateTotalPrice();
            });

            // Handle checkout button click event
            $('#checkoutBtn').click(function() {
                calculateTotalPrice();
                $('#checkoutForm').submit();
            });
            $('.edit-btn').click(function() {
                // Get the item ID and quantity from the data attributes of the button
                const itemId = $(this).data('item-id');
                const itemQuantity = $(this).data('item-quantity');

                // Set the quantity input value to the current quantity of the item
                $('#new_quantity').val(itemQuantity);

                // Set the "data-item-id" attribute of the modal to the item ID
                $('#editQuantityModal').data('item-id', itemId);

                // Show the modal
                $('#editQuantityModal').modal('show');
            });
            // Tangani klik tombol "Simpan" di dalam "Edit Quantity Modal"
            $('#saveQuantityBtn').click(function() {
                // Dapatkan jumlah baru dari input di dalam modal
                const newQuantity = $('#new_quantity').val();

                // Dapatkan ID barang dari atribut data di dalam modal
                const itemId = $('#editQuantityModal').data('item-id');

                // Kirim permintaan AJAX untuk memperbarui jumlah di database
                $.ajax({
                    type: "POST",
                    url: "keranjang.php",
                    data: {
                        action: "update_quantity",
                        item_id: itemId,
                        new_quantity: newQuantity
                    },
                    success: function(data) {
                        // Jika jumlah berhasil diperbarui, muat ulang halaman untuk memperbarui keranjang
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Jumlah barang berhasil di update',
                            showConfirmButton: false,
                            timer: 1500

                        })

                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            });
        });
    </script>
    <script>
        function performSearch() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const cartItems = document.querySelectorAll(".card");

            cartItems.forEach(item => {
                const itemName = item.querySelector(".card-title").innerText.toLowerCase();
                if (itemName.includes(searchInput)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        }

        function resetSearch() {
            const cartItems = document.querySelectorAll(".card");
            cartItems.forEach(item => {
                item.style.display = "block";
            });
            document.getElementById("searchInput").value = "";
        }
    </script>


</body>
</html>