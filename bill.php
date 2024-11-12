<?php

include 'konek.php';

// Mendapatkan id_transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Query untuk mengambil data dari database berdasarkan id_transaksi
$sql = "SELECT pembeli.nama, pembeli.no_meja, payment.nama_metode, transaksi.tgl_transaksi 
        FROM transaksi 
        JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli 
        JOIN payment ON transaksi.id_payment = payment.id_payment 
        WHERE transaksi.id_transaksi = '$id_transaksi'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mendapatkan hasil query
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $no_meja = $row['no_meja'];
    $payment = $row['nama_metode'];
    $tgl_transaksi = $row['tgl_transaksi'];
} else {
    echo "Data tidak ditemukan.";
    exit;
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Transaksi</title>
</head>
<body>
    <h2>Bill Transaksi</h2>
    <p>Nama: <?php echo htmlspecialchars($nama); ?></p>
    <p>Nomor Meja: <?php echo htmlspecialchars($no_meja); ?></p>
    <p>Metode Pembayaran: <?php echo htmlspecialchars($nama_metode); ?></p>
    <p>Tanggal Transaksi: <?php echo htmlspecialchars($tgl_transaksi); ?></p>
</body>
</html>
