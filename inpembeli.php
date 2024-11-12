<?php

session_start();
include 'konek.php';

// Menangkap data dari form
$nama = $_POST['nama'];
$no_meja = $_POST['no_meja'];
$id_payment = $_POST['id_payment'];
$id_kasir = $_SESSION['id_kasir']; // Ambil id_kasir dari sesi login

// Mulai transaksi
$conn->begin_transaction();

try {
    // 1. Simpan data ke tabel pembeli
    $sql_pembeli = "INSERT INTO pembeli (nama, no_meja) VALUES ('$nama', '$no_meja')";
    if ($conn->query($sql_pembeli) !== TRUE) {
        throw new Exception("Gagal menyimpan data pembeli: " . $conn->error);
    }

    // Ambil id_pembeli yang baru saja dimasukkan
    $id_pembeli = $conn->insert_id;

    // 2. Simpan data ke tabel transaksi, sekarang dengan id_kasir
    $sql_transaksi = "INSERT INTO transaksi (id_pembeli, id_payment, id_kasir, tgl_transaksi) 
                      VALUES ('$id_pembeli', '$id_payment', '$id_kasir', NOW())";
    if ($conn->query($sql_transaksi) !== TRUE) {
        throw new Exception("Gagal menyimpan data transaksi: " . $conn->error);
    }

    // Ambil id_transaksi dari transaksi yang baru saja disimpan
    $id_transaksi = $conn->insert_id;

    // Commit transaksi jika berhasil
    $conn->commit();

    // Redirect ke bill.php dengan parameter id_transaksi
    header("Location: bill.php?id_transaksi=$id_transaksi");
    exit;
} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$conn->close();
?>
