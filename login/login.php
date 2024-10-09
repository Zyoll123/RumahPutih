<?php

include 'konek.php';

// Ambil data dari form
$username = $_POST['nama'];
$password = $_POST['password'];

// Query untuk mencari user
$sql = "SELECT * FROM kasir WHERE nama='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: menu/menu.html");
    exit();
} else {
    echo "Login gagal! Username atau password salah.";
}

$conn->close();

?>