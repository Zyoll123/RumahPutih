<?php
session_start();
include 'konek.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

// Mendapatkan tanggal hari ini
$tanggal_hari_ini = date('Y-m-d');

// Cek apakah data dashboard untuk hari ini sudah ada
$sql_check_dashboard = $conn->prepare("SELECT * FROM dashboard WHERE tanggal = ?");
$sql_check_dashboard->bind_param("s", $tanggal_hari_ini);
$sql_check_dashboard->execute();
$result_dashboard = $sql_check_dashboard->get_result();

// Query untuk menghitung pendapatan hari ini
$sql_pendapatan = $conn->prepare(
    "SELECT SUM(total) AS pendapatan_hari_ini FROM transaksi WHERE DATE(tgl_transaksi) = ?"
);
$sql_pendapatan->bind_param("s", $tanggal_hari_ini);
$sql_pendapatan->execute();
$result_pendapatan = $sql_pendapatan->get_result();
$pendapatan_hari_ini = $result_pendapatan->fetch_assoc()['pendapatan_hari_ini'] ?? 0;

// Query untuk menghitung total produk yang terjual hari ini
$sql_produk_terjual = $conn->prepare(
    "SELECT SUM(detail_transaksi.quantity) AS total_produk_terjual 
     FROM detail_transaksi 
     INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi 
     WHERE DATE(transaksi.tgl_transaksi) = ?"
);
$sql_produk_terjual->bind_param("s", $tanggal_hari_ini);
$sql_produk_terjual->execute();
$result_produk_terjual = $sql_produk_terjual->get_result();
$total_produk_terjual = $result_produk_terjual->fetch_assoc()['total_produk_terjual'] ?? 0;

// Query untuk menghitung total pembeli hari ini
$sql_total_pembeli = $conn->prepare(
    "SELECT COUNT(DISTINCT id_pembeli) AS total_pembeli 
     FROM transaksi 
     WHERE DATE(tgl_transaksi) = ?"
);
$sql_total_pembeli->bind_param("s", $tanggal_hari_ini);
$sql_total_pembeli->execute();
$result_total_pembeli = $sql_total_pembeli->get_result();
$total_pembeli = $result_total_pembeli->fetch_assoc()['total_pembeli'] ?? 0;

if ($result_dashboard->num_rows === 0) {
    // Jika belum ada, masukkan data ringkasan untuk hari ini
    $sql_insert_dashboard = $conn->prepare(
        "INSERT INTO dashboard (tanggal, total_pendapatan, total_produk_terjual, total_pembeli)
         VALUES (?, ?, ?, ?)"
    );
    $sql_insert_dashboard->bind_param("siii", $tanggal_hari_ini, $pendapatan_hari_ini, $total_produk_terjual, $total_pembeli);
    $sql_insert_dashboard->execute();
    $sql_insert_dashboard->close();
} else {
    // Jika sudah ada, update data ringkasan untuk hari ini
    $sql_update_dashboard = $conn->prepare(
        "UPDATE dashboard
         SET total_pendapatan = ?, total_produk_terjual = ?, total_pembeli = ?
         WHERE tanggal = ?"
    );
    $sql_update_dashboard->bind_param("iiis", $pendapatan_hari_ini, $total_produk_terjual, $total_pembeli, $tanggal_hari_ini);
    $sql_update_dashboard->execute();
    $sql_update_dashboard->close();
}

$sql_check_dashboard->close();
$sql_pendapatan->close();
$sql_produk_terjual->close();
$sql_total_pembeli->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/cobastyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="dashboard">
            <h1>Dashboard</h1>

            <div class="dashboard-section">
                <h2>Pendapatan Hari Ini</h2>
                <p>Rp <?= number_format($pendapatan_hari_ini, 0, ',', '.'); ?></p>
            </div>

            <div class="dashboard-section">
                <h2>Total Produk Terjual</h2>
                <p><?= $total_produk_terjual; ?> Produk</p>
            </div>

            <div class="dashboard-section">
                <h2>Total Pembeli</h2>
                <p><?= $total_pembeli; ?> Orang</p>
            </div>

            <footer>
                <p>&copy; <?= date('Y'); ?> Sistem Manajemen Restoran</p>
            </footer>
        </div>
    </div>
</body>

</html>