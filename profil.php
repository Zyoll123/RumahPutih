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
                <img src="assets/user-avatar.png" alt="Azizah">
                <h1>Profil</h1><br>
                <p>Azizah</p>
            </div>
            <div class="profile-card">
                <h2>KASIR</h2>
                <?php

                $koneksi = mysqli_connect("localhost", "root", "", "rumahputih");

                // Check connection
                if (mysqli_connect_errno()) {
                    echo "Koneksi database gagal : " . mysqli_connect_error();
                }

                $result = $koneksi->query("SELECT * FROM kasir LIMIT 1 OFFSET 1"); // Ambil hanya satu data kasir
                if ($result) {
                    $d = $result->fetch_assoc();
                ?>
                    <div class="profile-item">
                        <span>Id Kasir :</span>
                        <span><?php echo $d['id_kasir']; ?></span>
                    </div>
                    <div class="profile-item">
                        <span>Username :</span>
                        <span><?php echo $d['username']; ?></span>
                    </div>
                    <div class="profile-item">
                        <span>No.Telp :</span>
                        <span><?php echo $d['no_telp']; ?></span>
                    </div>
                    <div class="profile-item">
                        <span>Password :</span>
                        <span><?php echo $d['password']; ?></span>
                    </div>
                    <div class="profile-item">
                        <span>Waktu Kerja :</span>
                        <span>15.30 - 21.00</span>
                    </div>
                <?php
                } else {
                    echo "<p>Tidak ada data yang ditemukan.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>