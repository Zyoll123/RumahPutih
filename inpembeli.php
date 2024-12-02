<?php
session_start();
include 'konek.php';

// Menangkap data dari form
$nama = $_POST['nama'];
$id_meja = $_POST['id_meja']; // Menggunakan id_meja dari tabel meja
$id_payment = $_POST['id_payment'];
$id_kasir = $_SESSION['id_kasir']; // Ambil id_kasir dari sesi login

// Validasi input
if (empty($nama) || empty($id_meja) || empty($id_payment)) {
    echo "Nama, nomor meja, dan metode pembayaran harus diisi.";
    exit;
}

// Memulai transaksi database
$conn->begin_transaction();

try {
    // 1. Simpan data ke tabel pembeli menggunakan prepared statements
    $sql_pembeli = $conn->prepare("INSERT INTO pembeli (nama_pembeli, id_meja, id_payment) VALUES (?, ?, ?)");
    $sql_pembeli->bind_param("sii", $nama, $id_meja, $id_payment);

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

    // 3. Update status meja menjadi 'terisi'
    $sql_update_meja = $conn->prepare("UPDATE meja SET status_meja = 'terisi' WHERE id_meja = ?");
    $sql_update_meja->bind_param("i", $id_meja);

    if (!$sql_update_meja->execute()) {
        throw new Exception("Gagal mengupdate status meja: " . $sql_update_meja->error);
    }

    // Commit transaksi jika semua langkah berhasil
    $conn->commit();

    // Redirect ke bill.php dengan parameter id_transaksi
    header("Location: bill.php?id_transaksi=$id_transaksi");
    exit;
} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    // Menutup koneksi dan statement
    if (isset($sql_pembeli)) $sql_pembeli->close();
    if (isset($sql_transaksi)) $sql_transaksi->close();
    if (isset($sql_update_meja)) $sql_update_meja->close();
    $conn->close();
}
?>
