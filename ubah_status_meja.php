<?php
include 'konek.php';

// Mengambil nomor meja dan status dari URL
$no_meja = $_GET['no_meja'];
$status = $_GET['status'];

// Update status meja menggunakan prepared statements
$sql = $conn->prepare("UPDATE meja SET status_meja = ? WHERE no_meja = ?");
$sql->bind_param("si", $status, $no_meja);

if ($sql->execute()) {
    echo "Status meja berhasil diubah.";
    // Redirect kembali ke halaman daftar meja
    header("Location: transaksi.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}

// Menutup koneksi
$sql->close();
$conn->close();
?>
