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

<body>
    <div class="big-three">
        <div class="side-bar">
            <img src="assets/Logo Rumah Putih.png" alt="logo">
            <div class="side-bar-item">
                <a href="index.php"><i class="fa-solid fa-house"></i>Home Page</a>
            </div>
            <div class="side-bar-item">
                <a href="history.php"><i class="fa-regular fa-file-lines"></i>History</a>
            </div>
            <div class="side-bar-item">
                <a href="edit.php"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
            </div>
            <div class="side-bar-item">
                <a href="setting.php"><i class="fa-solid fa-gear"></i>Setting</a>
            </div>
            <div class="side-bar-item">
                <a href="profil.php"><i class="fa-regular fa-user"></i>Profil</a>
            </div>
            <div class="log-out">
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
            </div>
        </div>

        <div class="container">
            <div class="profile-header">
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
                    <span>********</span> <!-- Jangan tampilkan password -->
                </div>
                <div class="profile-item">
                    <span>Waktu Kerja :</span>
                    <span>15.30 - 21.00</span>
                </div>
            </div>
            <div class="edit-profil">
                <a href="editprofile.php?id=<?php echo $_SESSION['id']; ?>&role=<?php echo $_SESSION['role']; ?>">Edit Profil</a>
            </div>
        </div>
    </div>
</body>

</html>
