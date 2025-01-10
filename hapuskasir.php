<?php

include 'konek.php';

if (isset($_GET['id_kasir'])) {
    // Mengambil id_kasir yang dikirimkan melalui URL
    $id_kasir = $_GET['id_kasir'];

    // Pastikan id_kasir adalah integer (untuk keamanan)
    $id_kasir = intval($id_kasir);

    // Memulai transaksi untuk memastikan konsistensi data
    $conn->begin_transaction();

    try {
        // 1. Ambil semua id_transaksi terkait dengan id_kasir
        $query_transaksi = "SELECT id_transaksi FROM transaksi WHERE id_kasir = ?";
        $stmt = $conn->prepare($query_transaksi);
        $stmt->bind_param('i', $id_kasir);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hapus data di detail_transaksi berdasarkan id_transaksi
        while ($row = $result->fetch_assoc()) {
            $id_transaksi = $row['id_transaksi'];
            $delete_detail = "DELETE FROM detail_transaksi WHERE id_transaksi = ?";
            $stmt_detail = $conn->prepare($delete_detail);
            $stmt_detail->bind_param('i', $id_transaksi);
            if (!$stmt_detail->execute()) {
                throw new Exception("Gagal menghapus data di detail_transaksi: " . $stmt_detail->error);
            }
        }

        // 2. Hapus data di tabel transaksi berdasarkan id_kasir
        $delete_transaksi = "DELETE FROM transaksi WHERE id_kasir = ?";
        $stmt_transaksi = $conn->prepare($delete_transaksi);
        $stmt_transaksi->bind_param('i', $id_kasir);
        if (!$stmt_transaksi->execute()) {
            throw new Exception("Gagal menghapus data di transaksi: " . $stmt_transaksi->error);
        }

        // 3. Hapus data di tabel kasir
        $delete_kasir = "DELETE FROM kasir WHERE id_kasir = ?";
        $stmt_kasir = $conn->prepare($delete_kasir);
        $stmt_kasir->bind_param('i', $id_kasir);
        if (!$stmt_kasir->execute()) {
            throw new Exception("Gagal menghapus data di kasir: " . $stmt_kasir->error);
        }

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect ke halaman setting.php setelah penghapusan berhasil
        header("Location: setting.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        // Tutup koneksi database
        $conn->close();
    }
} else {
    echo "ID kasir tidak ditemukan.";
}

?>
