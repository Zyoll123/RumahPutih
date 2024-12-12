<?php
session_start();
include 'konek.php';

// Menangkap data dari form
$nama = $_POST['nama'] ?? '';
$no_meja = $_POST['no_meja'] ?? ''; // Menggunakan no_meja dari tabel meja
$id_admin = $_SESSION['id']; // Ambil id admin dari sesi login
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

// Mengambil id kasir dari session
$id_kasir = $_SESSION['id']; // Pastikan id kasir diambil dari session

// Fungsi untuk menghitung subtotal
function hitungSubtotal($conn, $id_transaksi) {
    $subtotal = 0;

    // Mengambil detail transaksi
    $sql = $conn->prepare("SELECT id_produk, quantity FROM detail_transaksi WHERE id_transaksi = ?");
    $sql->bind_param("i", $id_transaksi);
    $sql->execute();
    $result = $sql->get_result();

    while ($row = $result->fetch_assoc()) {
        // Mengambil harga produk
        $sql_harga = $conn->prepare("SELECT harga_produk FROM produk WHERE id_produk = ?");
        $sql_harga->bind_param("i", $row['id_produk']);
        $sql_harga->execute();
        $result_harga = $sql_harga->get_result();
        $harga = $result_harga->fetch_assoc()['harga_produk'] ?? 0;

        // Hitung subtotal per produk
        $subtotal_per_produk = $harga * $row['quantity'];
        
        // Update subtotal pada detail_transaksi
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

// Memulai transaksi database
$conn->begin_transaction();

try {
    // 1. Simpan data ke tabel pembeli menggunakan prepared statements
    $sql_pembeli = $conn->prepare("INSERT INTO pembeli (nama_pembeli, no_meja) VALUES (?, ?)");
    $sql_pembeli->bind_param("si", $nama, $no_meja);

    if (!$sql_pembeli->execute()) {
        throw new Exception("Gagal menyimpan data pembeli: " . $sql_pembeli->error);
    }

    // Ambil id_pembeli yang baru saja dimasukkan
    $id_pembeli = $conn->insert_id;

    // 2. Simpan data ke tabel transaksi
    $sql_transaksi = $conn->prepare("INSERT INTO transaksi (id_pembeli, id_kasir, tgl_transaksi, uang_dibayar) VALUES (?, ?, NOW(), ?)");
    $sql_transaksi->bind_param("iii", $id_pembeli, $id_kasir, $uang_dibayar);

    if (!$sql_transaksi->execute()) {
        throw new Exception("Gagal menyimpan data transaksi: " . $sql_transaksi->error);
    }

    // Ambil id_transaksi dari transaksi yang baru saja disimpan
    $id_transaksi = $conn->insert_id;

    // 3. Update status meja menjadi 'terisi'
    $sql_update_meja = $conn->prepare("UPDATE meja SET status_meja = 'terisi' WHERE no_meja = ?");
    $sql_update_meja->bind_param("i", $no_meja);

    if (!$sql_update_meja->execute()) {
        throw new Exception("Gagal mengupdate status meja: " . $sql_update_meja->error);
    }

    // 4. Menambahkan produk yang dipesan ke transaksi
    foreach ($produk as $id_produk) {
        if (isset($quantity[$id_produk]) && $quantity[$id_produk] > 0) {
            $sql_order = $conn->prepare("INSERT INTO detail_transaksi (id_detailtransaksi, id_transaksi, id_produk, quantity) VALUES (?, ?, ?, ?)");
            $sql_order->bind_param("iiii", $id_transaksi, $id_transaksi, $id_produk, $quantity[$id_produk]);

            if (!$sql_order->execute()) {
                throw new Exception("Gagal menambahkan produk ke transaksi: " . $sql_order->error);
            }
        }
    }

    // 5. Hitung total
    $total = hitungSubtotal($conn, $id_transaksi);

    // 6. Update total dan kembalian
    $kembalian = $uang_dibayar - $total;
    if ($kembalian < 0) {
        throw new Exception("Uang yang dibayar kurang.");
    }

    // Update tabel transaksi dengan total dan kembalian
    $sql_update_transaksi = $conn->prepare("UPDATE transaksi SET total = ?, kembalian = ? WHERE id_transaksi = ?");
    $sql_update_transaksi->bind_param("iii", $total, $kembalian, $id_transaksi);
    if (!$sql_update_transaksi->execute()) {
        throw new Exception("Gagal mengupdate transaksi dengan total dan kembalian.");
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
