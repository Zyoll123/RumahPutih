<?php 

include 'konek.php';

$id_produk = mysqli_real_escape_string($conn, $_POST['id_produk']);
$nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
$harga = mysqli_real_escape_string($conn, $_POST['harga_produk']);
$stok = mysqli_real_escape_string($conn, $_POST['stok_produk']);
$id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

// Memproses gambar
if (isset($_FILES['gambar_produk']['tmp_name'])) {
    // Mendapatkan informasi file gambar
    $gambar = $_FILES['gambar_produk']['tmp_name'];
    $gambar_biner = addslashes(file_get_contents($gambar)); // Membaca isi file gambar
} else {
    echo "Tidak ada gambar yang diunggah!";
    exit;
}

// Query untuk menyimpan data produk termasuk gambar
$query = "update produk set nama = '$nama', harga = '$harga', stok = '$stok', id_kategori = '$id_kategori' where id_produk = '$id_produk'";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    echo "Produk berhasil diupdate!";
    header("Location: edit.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>