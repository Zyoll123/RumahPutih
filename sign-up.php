<?php
// Sertakan file koneksi database
include 'konek.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];
    $password = $_POST['password']; // Password tanpa hash

    // Query untuk memasukkan data ke dalam tabel users
    $sql = "INSERT INTO kasir (username, no_telp, password) VALUES (?, ?, ?)";

    // Gunakan prepared statements untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $no_telp, $password);

    // Eksekusi statement dan cek hasilnya
    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
        header("location:index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
