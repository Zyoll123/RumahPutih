<?php
session_start();
include 'konek.php';

// Menangkap data dari form
$nama = $_POST['nama'];
$no_meja = $_POST['no_meja'];
$id_payment = $_POST['id_payment'];
$id_kasir = $_SESSION['id_kasir']; // Ambil id_kasir dari sesi login

// Pastikan data yang diperlukan ada
if (empty($nama) || empty($no_meja) || empty($id_payment)) {
    echo "Nama, nomor meja, dan metode pembayaran harus diisi.";
    exit;
}

$conn->begin_transaction();

try {
    // 1. Simpan data ke tabel pembeli menggunakan prepared statements
    $sql_pembeli = $conn->prepare("INSERT INTO pembeli (nama, no_meja) VALUES (?, ?)");
    $sql_pembeli->bind_param("si", $nama, $no_meja);

    if (!$sql_pembeli->execute()) {
        throw new Exception("Gagal menyimpan data pembeli: " . $sql_pembeli->error);
    }

    // Ambil id_pembeli yang baru saja dimasukkan
    $id_pembeli = $conn->insert_id;

    // 2. Simpan data ke tabel transaksi
    $sql_transaksi = $conn->prepare("INSERT INTO transaksi (id_pembeli, id_payment, id_kasir, tgl_transaksi) 
                                     VALUES (?, ?, ?, NOW())");
    $sql_transaksi->bind_param("iii", $id_pembeli, $id_payment, $id_kasir);

    if (!$sql_transaksi->execute()) {
        throw new Exception("Gagal menyimpan data transaksi: " . $sql_transaksi->error);
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
} finally {
    // Menutup koneksi
    if (isset($sql_pembeli)) $sql_pembeli->close();
    if (isset($sql_transaksi)) $sql_transaksi->close();
    $conn->close();
}
?>
