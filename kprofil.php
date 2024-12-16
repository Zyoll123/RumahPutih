<?php
session_start();  // Memulai session

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.html");  // Redirect ke halaman login jika belum login
    exit();
}

include 'konek.php';  // Koneksi ke database

// Tentukan query berdasarkan peran dari session
if ($_SESSION['role'] === 'admin') {
    $id_user = $_SESSION['id'];
    $query = "SELECT * FROM admin WHERE id_admin = ?";
} elseif ($_SESSION['role'] === 'kasir') {
    $id_user = $_SESSION['id'];
    $query = "SELECT * FROM kasir WHERE id_kasir = ?";
} else {
    echo "Peran tidak valid.";
    exit();
}

// Persiapkan dan jalankan query
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);  // Menggunakan ID yang sesuai dengan tipe data (integer)
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFIL</title>
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<style>
    .container {
    position: relative; 
    flex: 1;
    display: flex;
    justify-content: center; 
    align-items: center; 
    background-color: #eef5f0;
}

.profile-header {
    position: absolute;
    top: 20px; /* Letak di kiri atas */
    left: 20px;
    text-align: left;
}

.profile-header img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #007acc;
}
.profile-header h1 {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    color: #333;
}

.profile-header h1 {
    font-size: 36px;
    color: #007acc;
    margin-bottom: 30px;
}

.profile-header p {
    margin-left: -110px;
    font-size: 20px;
    color: #005b99;
    margin-top: 20px;
}

.profile-card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 50%;
    max-width: 600px;
    margin-top: 200px;
}

.profile-card h2 {
    font-size: 24px;
    color: #005b99;
    margin-bottom: 15px;
}

.profile-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e6f7ff;
}

.profile-item span:first-child {
    font-weight: bold;
    color: #333;
}

.profile-item span:last-child {
    color: #555;
}

.edit-profil {
    position: absolute;
    bottom: -50px; /* Posisi kiri bawah */
    left: 20px;
}

.edit-profil a {
    text-decoration: none;
    background-color: #007acc;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.edit-profil a:hover {
    background-color: #005b99;
}

</style>

<body>
    <div class="big-three">
        <?php include 'ksidebar.php'; ?>

        <div class="container">
            <div class="profile-header">
                <img src="assets/Rectangle.png" alt="">
                <h1>Profil</h1><br>
                <p><?php echo $user['username']; ?></p> <!-- Menampilkan username -->
            </div>
            <div class="profile-card">
                <h2><?php echo $_SESSION['role'] === 'admin' ? 'Admin' : 'Kasir'; ?></h2>
                <div class="profile-item">
                    <span>Id Pengguna :</span>
                    <span><?php echo $_SESSION['id']; ?></span> <!-- Menampilkan ID sesuai peran -->
                </div>
                <div class="profile-item">
                    <span>Username :</span>
                    <span><?php echo $user['username']; ?></span>
                </div>
                <div class="profile-item">
                    <span>No. Telp :</span>
                    <span><?php echo $user['no_telp']; ?></span>
                </div>
                <div class="profile-item">
                    <span>Password :</span>
                    <span>******</span> <!-- Jangan tampilkan password -->
                </div>
                <div class="profile-item">
                    <span>Waktu Kerja :</span>
                    <span>15.30 - 21.00</span>
                </div>
            </div>
            <div class="edit-profil">
                <a href="keditprofil.php">Edit Profil</a>
            </div>
        </div>
    </div>
</body>

</html>