<?php
session_start();
include 'konek.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login_as = $_POST['login_as'];

    // Cek apakah login sebagai admin atau user
    if ($login_as === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM kasir WHERE username = ?");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password tanpa hash (langsung dibandingkan dengan database)
        if ($password === $user['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Arahkan ke halaman sesuai peran
            if ($login_as === 'admin') {
                header("Location: index.php");
            } else {
                header("Location: kasir/user.php");
            }
            exit();
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