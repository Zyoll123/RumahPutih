<?php

include 'konek.php';

// Mendapatkan id_transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Query untuk mengambil data dari tabel transaksi dan pembeli
$sql = "SELECT pembeli.nama_pembeli, pembeli.no_meja, transaksi.id_transaksi, transaksi.total, transaksi.kembalian, transaksi.tgl_transaksi 
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
<body>
    <h2>Bill Transaksi</h2>
    <p>Nama: <?php echo htmlspecialchars($nama_pembeli); ?></p>
    <p>No Transaksi: <?php echo htmlspecialchars($id_transaksi); ?></p>
    <p>Nomor Meja: <?php echo htmlspecialchars($no_meja); ?></p>
    <p>Tanggal Transaksi: <?php echo htmlspecialchars($tgl_transaksi); ?></p>

    <h3>Detail Pembelian:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
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

    <p><strong>Total Pembelian: <?php echo htmlspecialchars($total); ?></strong></p>
    <p>Kembalian: <?php echo htmlspecialchars($kembalian); ?></p>
</body>
</html>
