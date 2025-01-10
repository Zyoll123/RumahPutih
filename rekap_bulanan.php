<?php
session_start();
include 'konek.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

// Ambil semua data dari tabel dashboard berdasarkan bulan
$sql_rekap_bulanan = "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, 
           SUM(total_pendapatan) AS total_pendapatan, 
           SUM(total_produk_terjual) AS total_produk_terjual, 
           SUM(total_pembeli) AS total_pembeli
    FROM dashboard
    GROUP BY bulan
    ORDER BY bulan DESC";
$result_rekap_bulanan = $conn->query($sql_rekap_bulanan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <link rel="stylesheet" href="css/cobastyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
     * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #dde9dd;
    }

    .big-three {
        display: flex;
        justify-content: flex-start;
    }

    .side-bar {
        display: inline;
        position: fixed;
        height: 100%;
        width: 200px;
        background-color: #ffff;
        border-right: 1px solid #979494;
        left: 0;
    }

    .side-bar img {
        width: 150px;
        margin: 20px;
    }

    .side-bar-item {
        margin-top: 5px;
        margin-bottom: 30px;
        margin-left: 20px;
    }

    .side-bar-item:hover a {
        color: #9cc1e5;
    }

    .side-bar-item a {
        text-decoration: none;
        color: black;
    }

    .side-bar-item a i {
        margin-right: 10px;
    }

    .log-out {
        margin-top: 170px;
        margin-left: 20px;
    }

    .log-out:hover a {
        color: #9cc1e5;
    }

    .log-out a {
        text-decoration: none;
        color: black;
    }

    .log-out a i {
        margin-right: 10px;
    }

    .dashboard {
        padding: 20px;
    }

    .dashboard h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 10px;
    }

    table th {
        background-color: #41729F;
        color: white;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        text-decoration: none;
        background-color: #41729F;
        color: white;
        border-radius: 5px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #9cc1e5;
    }

    @media screen and (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto;
        }

        .dashboard {
            padding: 10px;
        }
    }
</style>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="dashboard">
            <h1>Rekap Bulanan</h1>

            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Pendapatan</th>
                        <th>Total Produk Terjual</th>
                        <th>Total Pembeli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_rekap_bulanan->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['bulan']; ?></td>
                            <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
                            <td><?= $row['total_produk_terjual']; ?> Produk</td>
                            <td><?= $row['total_pembeli']; ?> Orang</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <a href="index.php" class="btn">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>