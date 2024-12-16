<?php

include 'konek.php';

// Mendapatkan id_transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Query untuk mengambil data dari tabel transaksi dan pembeli
$sql = "SELECT pembeli.nama_pembeli, transaksi.no_meja, transaksi.id_transaksi, transaksi.total, transaksi.kembalian, transaksi.tgl_transaksi 
        FROM transaksi 
        JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli 
        WHERE transaksi.id_transaksi = '$id_transaksi'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mendapatkan hasil query
    $row = $result->fetch_assoc();
    $id_transaksi = $row['id_transaksi'];
    $nama_pembeli = $row['nama_pembeli'];
    $no_meja = $row['no_meja'];
    $total = $row['total'];
    $kembalian = $row['kembalian'];
    $tgl_transaksi = $row['tgl_transaksi'];
} else {
    echo "Data tidak ditemukan.";
    exit;
}

// Query untuk mengambil detail transaksi
$sql_detail = "SELECT produk.nama_produk, detail_transaksi.quantity, detail_transaksi.subtotal 
               FROM detail_transaksi 
               JOIN produk ON detail_transaksi.id_produk = produk.id_produk 
               WHERE detail_transaksi.id_transaksi = '$id_transaksi'";

$result_detail = $conn->query($sql_detail);

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Transaksi</title>
    <link rel="stylesheet" href="css/bill.css">
</head>
<style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    /* Body */
    body {
        background-color: #f5f5f5;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* Bill Container */
    .bill-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Header */
    .bill-header {
        text-align: center;
        margin-bottom: 10px;
    }

    .bill-header img {
        width: 50px;
        height: auto;
        margin-bottom: 5px;
    }

    .bill-header h2 {
        font-size: 18px;
        font-weight: bold;
    }

    /* Customer Info */
    .customer-info {
        margin-bottom: 10px;
    }

    .customer-info p {
        margin: 5px 0;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table th, table td {
        text-align: left;
        padding: 5px;
        border-bottom: 1px solid #ddd;
    }

    table th {
        font-weight: bold;
        background-color: #f9f9f9;
    }

    table td {
        color: #555;
    }

    /* Total and Kembalian */
    .total {
        font-weight: bold;
        font-size: 16px;
        text-align: right;
        margin-top: 10px;
    }

    .kembalian {
        text-align: right;
        font-size: 14px;
        color: #777;
    }

    /* Button - Separate Container */
    .kembali-container {
        text-align: center;
        margin-top: 20px;
    }

    .kembali-container a {
        text-decoration: none;
        background-color: #1e88e5;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .kembali-container a:hover {
        background-color: #1565c0;
    }

</style>
<body>
    <!-- Bill Container -->
    <div class="bill-container">
        <div class="bill-header">
            <!-- Gambar Logo -->
            <img src="assets/l1.png" alt="Logo Omah Putih">
            <h2>Bill Transaksi</h2>
        </div>
        <div class="customer-info">
            <p>Nama: <?php echo htmlspecialchars($nama_pembeli); ?></p>
            <p>No Transaksi: <?php echo htmlspecialchars($id_transaksi); ?></p>
            <p>Nomor Meja: <?php echo htmlspecialchars($no_meja); ?></p>
            <p>Tanggal Transaksi: <?php echo htmlspecialchars($tgl_transaksi); ?></p>
        </div>

        <!-- Tabel Detail Pembelian -->
        <h3>Detail Pembelian:</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_detail->num_rows > 0): ?>
                    <?php while ($detail = $result_detail->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['nama_produk']); ?></td>
                            <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($detail['subtotal']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Tidak ada data detail transaksi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Total dan Kembalian -->
        <div class="total">
            Total Pembelian: Rp <?php echo htmlspecialchars($total); ?>
        </div>
        <div class="kembalian">
            Kembalian: Rp <?php echo htmlspecialchars($kembalian); ?>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="kembali-container">
        <a href="kasir.php">Kembali ke Pemesanan</a>
    </div>
</body>
</html>
