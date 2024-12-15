<?php
session_start();
include 'konek.php';

// Menangkap data dari form
$nama = $_POST['nama'] ?? '';
$no_meja = $_POST['no_meja'] ?? '';
$id_admin = $_SESSION['id'];
$produk = $_POST['produk'] ?? [];
$quantity = $_POST['quantity'] ?? [];
$uang_dibayar = $_POST['uang_dibayar'] ?? 0;

// Validasi input
if (empty($nama) || empty($no_meja)) {
    echo "Nama dan nomor meja harus diisi.";
    exit;
}

if (empty($produk)) {
    echo "Pilih produk yang ingin dipesan.";
    exit;
}

// Fungsi untuk menghitung subtotal
function hitungSubtotal($conn, $id_transaksi) {
    $subtotal = 0;

    $sql = $conn->prepare("SELECT id_produk, quantity FROM detail_transaksi WHERE id_transaksi = ?");
    $sql->bind_param("i", $id_transaksi);
    $sql->execute();
    $result = $sql->get_result();

    while ($row = $result->fetch_assoc()) {
        $sql_harga = $conn->prepare("SELECT harga_produk FROM produk WHERE id_produk = ?");
        $sql_harga->bind_param("i", $row['id_produk']);
        $sql_harga->execute();
        $result_harga = $sql_harga->get_result();
        $harga = $result_harga->fetch_assoc()['harga_produk'] ?? 0;

        $subtotal_per_produk = $harga * $row['quantity'];

        $sql_update_subtotal = $conn->prepare("UPDATE detail_transaksi SET subtotal = ? WHERE id_transaksi = ? AND id_produk = ?");
        $sql_update_subtotal->bind_param("dii", $subtotal_per_produk, $id_transaksi, $row['id_produk']);
        $sql_update_subtotal->execute();
        $sql_update_subtotal->close();

        $subtotal += $subtotal_per_produk;
        $sql_harga->close();
    }

    $sql->close();
    return $subtotal;
}

// Fungsi untuk mereset status meja jika semua sudah terisi
function resetStatusMejaJikaPenuh($conn) {
    $sql_cek = "SELECT COUNT(*) as total_meja, SUM(status_meja = 'terisi') as meja_terisi FROM meja";
    $result = $conn->query($sql_cek);

    if ($result) {
        $data = $result->fetch_assoc();
        $total_meja = $data['total_meja'];
        $meja_terisi = $data['meja_terisi'];

        if ($total_meja == $meja_terisi) {
            $sql_reset = "UPDATE meja SET status_meja = 'kosong'";
            if ($conn->query($sql_reset)) {
                echo "Semua meja telah direset ke status 'kosong'.";
            } else {
                echo "Gagal mereset status meja: " . $conn->error;
            }
        }
    } else {
        echo "Gagal memeriksa status meja: " . $conn->error;
    }
}

// Memulai transaksi database
$conn->begin_transaction();

try {
    $sql_pembeli = $conn->prepare("INSERT INTO pembeli (nama_pembeli) VALUES (?)");
    $sql_pembeli->bind_param("s", $nama);

    if (!$sql_pembeli->execute()) {
        throw new Exception("Gagal menyimpan data pembeli: " . $sql_pembeli->error);
    }

    $id_pembeli = $conn->insert_id;

    $sql_transaksi = $conn->prepare("INSERT INTO transaksi (id_pembeli, id_kasir, no_meja, tgl_transaksi, uang_dibayar) VALUES (?, ?, ?, NOW(), ?)");
    $sql_transaksi->bind_param("iiii", $id_pembeli, $id_admin, $no_meja, $uang_dibayar);

    if (!$sql_transaksi->execute()) {
        throw new Exception("Gagal menyimpan data transaksi: " . $sql_transaksi->error);
    }

    $id_transaksi = $conn->insert_id;

    $sql_update_meja = $conn->prepare("UPDATE meja SET status_meja = 'terisi' WHERE no_meja = ?");
    $sql_update_meja->bind_param("i", $no_meja);

    if (!$sql_update_meja->execute()) {
        throw new Exception("Gagal mengupdate status meja: " . $sql_update_meja->error);
    }

    foreach ($produk as $id_produk) {
        if (isset($quantity[$id_produk]) && $quantity[$id_produk] > 0) {
            $sql_order = $conn->prepare("INSERT INTO detail_transaksi (id_detailtransaksi, id_transaksi, id_produk, quantity) VALUES (?, ?, ?, ?)");
            $sql_order->bind_param("iiii", $id_transaksi, $id_transaksi, $id_produk, $quantity[$id_produk]);

            if (!$sql_order->execute()) {
                throw new Exception("Gagal menambahkan produk ke transaksi: " . $sql_order->error);
            }
        }
    }

    $total = hitungSubtotal($conn, $id_transaksi);

    $kembalian = $uang_dibayar - $total;
    if ($kembalian < 0) {
        throw new Exception("Uang yang dibayar kurang.");
    }

    $sql_update_transaksi = $conn->prepare("UPDATE transaksi SET total = ?, kembalian = ? WHERE id_transaksi = ?");
    $sql_update_transaksi->bind_param("iii", $total, $kembalian, $id_transaksi);
    if (!$sql_update_transaksi->execute()) {
        throw new Exception("Gagal mengupdate transaksi dengan total dan kembalian.");
    }

    $conn->commit();

    // Reset status meja jika semua sudah terisi
    resetStatusMejaJikaPenuh($conn);

    header("Location: bill.php?id_transaksi=$id_transaksi");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
