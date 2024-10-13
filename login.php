<?php
session_start();
require 'konek.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Melakukan query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM tb_kasir WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan data user dalam session
            $_SESSION['id_kasir'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Login berhasil! Selamat datang, " . htmlspecialchars($user['username']) . ".";
            header("Location: index.php");
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    $stmt->close();
}
$conn->close();
?>
