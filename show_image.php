<?php
include 'konek.php'; // Koneksi ke database

// Mendapatkan ID produk dari parameter URL
$id_produk = mysqli_real_escape_string($conn, $_GET['id_produk']);

// Query untuk mengambil gambar berdasarkan ID produk
$query = "SELECT gambar_produk FROM produk WHERE id_produk = '$id_produk'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    header("Content-type: image/jpeg"); // Mengatur header sesuai tipe gambar
    echo $row['gambar_produk']; // Menampilkan gambar
} else {
    echo "Gambar tidak ditemukan.";
}
?>
