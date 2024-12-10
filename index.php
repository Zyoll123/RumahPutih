<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

include 'konek.php';

// Tangkap input tambah produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $id_produk = $_POST['id_produk'];
    $quantity = $_POST['quantity'];

    // Validasi data
    if ($quantity > 0) {
        $id_kasir = $_SESSION['id'];
        $tanggal = date("Y-m-d");

        // Cek apakah transaksi sudah ada untuk user ini
        $query_check_transaksi = "SELECT id_transaksi FROM transaksi WHERE id_kasir = ? AND total = 0";
        $stmt_check = $conn->prepare($query_check_transaksi);
        $stmt_check->bind_param("i", $id_kasir);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $id_transaksi = $row['id_transaksi'];
        } else {
            // Buat transaksi baru
            $query_transaksi = "INSERT INTO transaksi (tgl_transaksi, total, id_kasir, id_pembeli) VALUES (?, 0, ?, NULL)";
            $stmt_transaksi = $conn->prepare($query_transaksi);
            $stmt_transaksi->bind_param("si", $tanggal, $id_kasir);
            $stmt_transaksi->execute();
            $id_transaksi = $conn->insert_id;
        }

        // Ambil harga produk
        $query_harga = "SELECT harga_produk FROM produk WHERE id_produk = ?";
        $stmt_harga = $conn->prepare($query_harga);
        $stmt_harga->bind_param("i", $id_produk);
        $stmt_harga->execute();
        $result_harga = $stmt_harga->get_result();

        if ($result_harga->num_rows > 0) {
            $row_harga = $result_harga->fetch_assoc();
            $harga_produk = $row_harga['harga_produk'];
            $subtotal = $harga_produk * $quantity;

            // Tambahkan detail transaksi
            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) VALUES (?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($query_detail);
            $stmt_detail->bind_param("iiid", $id_transaksi, $id_produk, $quantity, $subtotal);
            $stmt_detail->execute();

            // Update total transaksi
            $query_update_total = "UPDATE transaksi SET total = total + ? WHERE id_transaksi = ?";
            $stmt_update = $conn->prepare($query_update_total);
            $stmt_update->bind_param("di", $subtotal, $id_transaksi);
            $stmt_update->execute();

            echo "<script>alert('Produk berhasil ditambahkan ke transaksi!');</script>";
        } else {
            echo "<script>alert('Produk tidak ditemukan!');</script>";
        }
    } else {
        echo "<script>alert('Jumlah produk harus lebih dari 0!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
            <?php include 'sidebar.php'; ?>
            <div class="search-container">
                <form method="GET" action="">
                    <div class="form-grup">
                        <input type="text" class="form-input" id="search-input" name="search" placeholder="Search Menu" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="order-information">
                <div class="top-info">
                    <div class="logo-info">
                        <img src="assets/Rectangle.png" alt="">
                        <div class="kasir-info">
                            <p><?php echo $_SESSION['username']; ?></p>
                            <p>id: <?php echo $_SESSION['id']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="mid-info">
                    <h3>Order : </h3>
                    <div class="radio-place">
                        <input type="radio" id="pilihan-1" name="place" value="pilihan-1">
                        <label for="pilihan-1" class="custom-radio">Dine In</label>
                        <input type="radio" id="pilihan-2" name="place" value="pilihan-2">
                        <label for="pilihan-2" class="custom-radio">Take Away</label>
                    </div>
                    <p>Tanggal : <?php echo date("d-m-Y"); ?></p>
                </div>
                <div class="buttom-info">
                    <a href="transaksi.php">Place On Order</a>
                </div>
                <div class="order-summary">
                    <h4>Menu yang Dipesan:</h4>
                    <ul>
                        <?php
                        $query_summary = "SELECT p.nama_produk, d.jumlah, d.subtotal FROM detail_transaksi d JOIN produk p ON d.id_produk = p.id_produk JOIN transaksi t ON d.id_transaksi = t.id_transaksi WHERE t.id_kasir = ? AND t.total > 0 ORDER BY d.id_detail DESC LIMIT 5";
                        $stmt_summary = $conn->prepare($query_summary);
                        $stmt_summary->bind_param("i", $_SESSION['id']);
                        $stmt_summary->execute();
                        $result_summary = $stmt_summary->get_result();

                        if ($result_summary && $result_summary->num_rows > 0) {
                            while ($row = $result_summary->fetch_assoc()) {
                                echo "<li>{$row['nama_produk']} (x{$row['jumlah']}) - Rp {$row['subtotal']}</li>";
                            }
                        } else {
                            echo "<li>Belum ada menu yang dipesan.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu-juga">
            <?php
            // Tangkap input pencarian
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Query pencarian
            $query = "SELECT * FROM produk WHERE nama_produk LIKE '%$search%'";
            $data = mysqli_query($conn, $query);

            // Tampilkan hasil pencarian
            if (mysqli_num_rows($data) > 0) {
                while ($d = mysqli_fetch_array($data)) {
            ?>
                    <div class="menu-container">
                        <div class="menu">
                            <p><?php echo $d['nama_produk']; ?></p>
                            <div class="menu-item">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                                <div class="menu-info">
                                    <p>Rp <?php echo $d['harga_produk']; ?></p>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_produk" value="<?php echo $d['id_produk']; ?>">
                                        <div class="input-number-container">
                                            <button type="button" class="minusBtn">-</button>
                                            <input type="number" class="numberInput" name="quantity" value="1" min="1" max="1000">
                                            <button type="button" class="plusBtn">+</button>
                                        </div>
                                        <button type="submit" name="add_product" class="input">Tambah Produk</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p style='text-align: center; color: gray;'>Hasil tidak ditemukan.</p>";
            }
            ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>