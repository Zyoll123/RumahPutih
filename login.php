<?php
session_start();
include 'konek.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Hapus spasi tambahan
    $password = trim($_POST['password']); // Hapus spasi tambahan
    $login_as = $_POST['login_as'];

    // Tentukan query berdasarkan peran (admin/kasir)
    if ($login_as === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM kasir WHERE username = ? AND password = ?");
    }

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);

        // Eksekusi statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            exit();
        }

        $result = $stmt->get_result();

        // Cek apakah user ditemukan
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Simpan data user ke sesi
            $_SESSION['id_admin'] = $user['id_admin'] ?? $user['id_kasir']; // Gunakan ID sesuai peran
            $_SESSION['username'] = $user['username'];

        if ($login_as === 'admin') {
                    header("Location: index.php");
                    exit();
            } else {
                    header("Location: user.php");
                    exit();
                }
            exit();
        } else {
            echo "Username atau password salah.";
        }

        $stmt->close();
    } else {
        echo "Terjadi kesalahan pada server.";
    }
}

$conn->close();
?>
