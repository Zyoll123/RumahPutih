<?php
session_start();
include 'konek.php';

// Validasi role pengguna
if ($_SESSION['role'] === 'admin') {
    $id = $_POST['id_admin'];
    $query = "UPDATE admin SET username = ?, no_telp = ?, password = ? WHERE id_admin = ?";
} elseif ($_SESSION['role'] === 'kasir') {
    $id = $_POST['id_kasir'];
    $query = "UPDATE kasir SET username = ?, no_telp = ?, password = ? WHERE id_kasir = ?";
} else {
    echo "Role tidak valid.";
    exit();
}

// Validasi input
$username = $_POST['username'];
$no_telp = $_POST['no_telp'];
$password = !empty($_POST['password']) ? $_POST['password'] : null;

if ($stmt = $conn->prepare($query)) {
    if ($password !== null) {
        // Jika password diisi, masukkan ke database
        $stmt->bind_param("sssi", $username, $no_telp, $password, $id);
    } else {
        // Jika password kosong, tetap gunakan password lama
        $query = str_replace(", password = ?", "", $query); // Hapus bagian password dari query
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $username, $no_telp, $id);
    }
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Tidak ada data yang diubah.";
    }

    $stmt->close();
} else {
    echo "Kesalahan dalam query.";
}
?>