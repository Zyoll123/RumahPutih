<?php
include 'konek.php';

$id_produk = $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$harga_produk = $_POST['harga_produk'];
$id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : null;

// Ambil id_kategori lama dari database jika user tidak memilih kategori baru
if ($id_kategori === null) {
    $result = mysqli_query($conn, "SELECT id_kategori FROM produk WHERE id_produk = '$id_produk'");
    $row = mysqli_fetch_assoc($result);
    $id_kategori = $row['id_kategori'];
}

// Cek jika ada file gambar baru yang diunggah
if (!empty($_FILES['gambar_produk_baru']['tmp_name'])) {
    // Ambil konten file gambar
    $gambar_produk_baru = addslashes(file_get_contents($_FILES['gambar_produk_baru']['tmp_name']));

    // Query untuk mengupdate data dengan gambar baru
    $query = "UPDATE produk SET 
                nama_produk='$nama_produk',
                harga_produk='$harga_produk',
                gambar_produk='$gambar_produk_baru',
                id_kategori='$id_kategori' 
              WHERE id_produk='$id_produk'";
} else {
    // Jika tidak ada gambar baru, update data tanpa mengganti gambar
    $query = "UPDATE produk SET 
                nama_produk='$nama_produk',
                harga_produk='$harga_produk',
                id_kategori='$id_kategori' 
              WHERE id_produk='$id_produk'";
}

// Jalankan query
mysqli_query($conn, $query);
header("Location: edit.php");
?>