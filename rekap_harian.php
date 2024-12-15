<?php
session_start();
include 'konek.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

// Ambil semua data dari tabel dashboard
$sql_rekap = "SELECT * FROM dashboard ORDER BY tanggal DESC";
$result_rekap = $conn->query($sql_rekap);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Harian</title>
    <link rel="stylesheet" href="css/cobastyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
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
            <h1>Rekap Harian</h1>

            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Pendapatan</th>
                        <th>Total Produk Terjual</th>
                        <th>Total Pembeli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_rekap->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['tanggal']; ?></td>
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