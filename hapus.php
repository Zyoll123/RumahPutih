<?php

include 'konek.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Hapus data terkait di detail_transaksi
    mysqli_query($conn, "DELETE FROM detail_transaksi WHERE Id_produk='$id'");
    
    // Hapus data di tabel produk
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id'");
    header("Location: index.php");
} else {
    echo "ID tidak ditemukan.";
}

?>