<?php

include 'konek.php';

if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];

    // Memulai transaksi untuk memastikan konsistensi data
    $conn->begin_transaction();

    try {
        // 1. Ambil semua id_transaksi terkait dengan id_kasir
        $query_transaksi = "SELECT id_transaksi FROM transaksi WHERE id_kasir='$id_kasir'";
        $result = mysqli_query($conn, $query_transaksi);

        // Hapus data di detail_transaksi berdasarkan id_transaksi
        while ($row = mysqli_fetch_assoc($result)) {
            $id_transaksi = $row['id_transaksi'];
            $delete_detail = "DELETE FROM detail_transaksi WHERE Id_transaksi='$id_transaksi'";
            if (!mysqli_query($conn, $delete_detail)) {
                throw new Exception("Gagal menghapus data di detail_transaksi: " . mysqli_error($conn));
            }
        }

        // 2. Hapus data di tabel transaksi berdasarkan id_kasir
        $delete_transaksi = "DELETE FROM transaksi WHERE id_kasir='$id_kasir'";
        if (!mysqli_query($conn, $delete_transaksi)) {
            throw new Exception("Gagal menghapus data di transaksi: " . mysqli_error($conn));
        }

        // 3. Hapus data di tabel kasir
        $delete_kasir = "DELETE FROM kasir WHERE id_kasir='$id_kasir'";
        if (!mysqli_query($conn, $delete_kasir)) {
            throw new Exception("Gagal menghapus data di kasir: " . mysqli_error($conn));
        }

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect ke halaman kasir
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
    echo "ID tidak ditemukan.";
}
