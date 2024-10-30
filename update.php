<?php
include 'konek.php';

$id_produk = $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$harga_produk = $_POST['harga_produk'];
$stok_produk = $_POST['stok_produk'];
$id_kategori = $_POST['id_kategori'];

// Cek jika ada file gambar baru yang diunggah
if (!empty($_FILES['gambar_produk_baru']['tmp_name'])) {
    // Ambil konten file gambar
    $gambar_produk_baru = addslashes(file_get_contents($_FILES['gambar_produk_baru']['tmp_name']));

    // Query untuk mengupdate data dengan gambar baru
    $query = "UPDATE produk SET 
                nama_produk='$nama_produk',
                harga_produk='$harga_produk',
                stok_produk='$stok_produk',
                gambar_produk='$gambar_produk_baru',
                id_kategori='$id_kategori' 
              WHERE id_produk='$id_produk'";
} else {
    // Jika tidak ada gambar baru, update data tanpa mengganti gambar
    $query = "UPDATE produk SET 
                nama_produk='$nama_produk',
                harga_produk='$harga_produk',
                stok_produk='$stok_produk',
                id_kategori='$id_kategori' 
              WHERE id_produk='$id_produk'";
}

mysqli_query($conn, $query);
header("Location: index.php");
?>
