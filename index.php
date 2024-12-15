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
<style>
    /* Reset Margin dan Padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Warna latar belakang utama */
    body {
        background-color: #dde9dd;
    }

    /* Struktur Dashboard */
    .big-three {
        display: flex;
        justify-content: flex-start;
    }

    /* Sidebar */
    .side-bar {
        position: fixed;
        height: 100%;
        width: 200px;
        background-color: #ffff;
        border-right: 1px solid #979494;
    }

    .side-bar img {
        width: 150px;
        margin: 20px auto;
        display: block;
    }

    .side-bar-item {
        margin: 20px;
    }

    .side-bar-item:hover a,
    .log-out:hover a {
        color: #9cc1e5;
        transition: color 0.3s;
    }

    .side-bar-item a,
    .log-out a {
        text-decoration: none;
        color: black;
        display: flex;
        align-items: center;
    }

    .side-bar-item a i,
    .log-out a i {
        margin-right: 10px;
    }

    .log-out {
        margin-top: auto;
        margin-left: 20px;
    }

    /* Area Dashboard */
    .dashboard {
        margin-left: 200px;
        padding: 30px;
        width: calc(100% - 200px);
        background-color: #eaf5e6;
        min-height: 100vh;
    }

    .dashboard h1 {
        font-size: 32px;
        color: #2d3e50;
        margin-bottom: 30px;
    }

    /* Kotak Statistik */
    .kotak {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .dashboard-section1,
    .dashboard-section2,
    .dashboard-section3 {
        background-color: #DDE3E9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s, background-color 0.3s;
    }

    .dashboard-section1:hover,
    .dashboard-section2:hover,
    .dashboard-section3:hover {
        background-color: #cdd7e1;
        transform: scale(1.05);
    }

    .dashboard-section h2 {
        font-size: 30px;
        color: #333;
        margin-bottom: 10px;
    }

    .pr {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 25px;
        color: #769dc6;
        font-weight: bold;
    }

    /* Tombol Rekap */
    .rekap {
        text-align: center;
        margin-top: 50px;
        
    }

    .rekap-button {
        width: 150px;
        height: 40px;
        margin-top: 300px;
        margin-left: 85%;
        background-color: #769dc6;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .rekap-button:hover {
        background-color: #5b83a8;
        transform: scale(1.1);
        cursor: pointer;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .side-bar {
            width: 100px;
        }

        .side-bar img {
            width: 80px;
        }

        .side-bar-item a {
            font-size: 12px;
        }

        .dashboard {
            margin-left: 100px;
            padding: 20px;
        }

        .kotak {
            grid-template-columns: 1fr;
        }

        .rekap {
            margin-top: 20px;
        }
    }
</style>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="dashboard">
            <h1>Dashboard</h1>
            <div class="kotak">
                <div class="dashboard-section1">
                    <h2>Pendapatan Hari Ini</h2>
                    <div class="pr">
                        <p>Rp <?= number_format($pendapatan_hari_ini, 0, ',', '.'); ?></p>
                    </div>
                </div>

                <div class="dashboard-section2">
                    <h2>Total Produk Terjual</h2>
                    <div class="pr">
                        <p><?= $total_produk_terjual; ?> Produk</p>
                    </div>
                </div>

                <div class="dashboard-section3">
                    <h2>Total Pembeli</h2>
                    <div class="pr">
                        <p><?= $total_pembeli; ?> Orang</p>
                    </div>
                </div>
            </div>
            <div class="rekap">
                <a href="rekap_harian.php"><button class="rekap-button">Rekap</button></a>
            </div>

        </div>
    </div>
    </div>
</body>

</html>