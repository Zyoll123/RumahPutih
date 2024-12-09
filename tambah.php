<?php
include 'konek.php'; // Koneksi ke database

// Mendapatkan data dari form
$nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
$harga = mysqli_real_escape_string($conn, $_POST['harga_produk']);
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
$query = "INSERT INTO produk (nama_produk, harga_produk, gambar_produk, id_kategori) 
          VALUES ('$nama', '$harga', '$gambar_biner', '$id_kategori')";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    echo "Produk berhasil ditambahkan!";
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>