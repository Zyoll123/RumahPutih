<?php

include 'konek.php';

if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];
    // Hapus data terkait di detail_transaksi
    mysqli_query($conn, "DELETE FROM transaksi WHERE Id_kasir='$id_kasir'");
    
    // Hapus data di tabel produk
    mysqli_query($conn, "DELETE FROM kasir WHERE id_kasir='$id_kasir'");
    header("Location: kasir.php");
} else {
    echo "ID tidak ditemukan.";
}

?>