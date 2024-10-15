<?php
session_start();
include 'konek.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menyiapkan statement untuk menghindari SQL Injection
    $query = "SELECT * FROM kasir WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['id_kasir'] = $user['id_kasir'];
        $_SESSION['username'] = $user['username'];
        
        header("Location: index.php");
        exit();
    } else {
        echo "Username atau password salah.";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
