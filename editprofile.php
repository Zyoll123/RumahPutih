<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/tambahmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
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

        <div class="isi">
            <div class="judul">
                <h1>Edit Profile</h1>
            </div>

            <?php
            include 'konek.php';

            // Cek apakah 'id_produk' ada di URL
            if (isset($_GET['id_admin'])) {
                $id_admin = $_GET['id_admin'];

                // Query untuk mengambil data produk berdasarkan id_produk
                $query_produk = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
                $result_produk = mysqli_query($conn, $query_produk);

                // Jika produk ditemukan
                if ($result_produk && mysqli_num_rows($result_produk) > 0) {
                    $d = mysqli_fetch_assoc($result_produk);
                } else {
                    echo "Data pengguna tidak ditemukan.";
                    exit;
                }

            } else {
                echo "ID admin tidak disediakan.";
                exit;
            }
            ?>

            <form method="post" action="updateadmin.php" enctype="multipart/form-data">
                <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($d['id_admin']); ?>">

                <div class="form-grup">
                    <input type="text" class="form-input" id="nama" name="username" value="<?php echo htmlspecialchars($d['username']); ?>" oninput="toggleLabel(this)">
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" id="harga" name="no_telp" value="<?php echo htmlspecialchars($d['no_telp']); ?>" oninput="toggleLabel(this)">
                </div>

                <div class="form-grup">
                    <input type="password" class="form-input" id="stok" name="password" value="<?php echo htmlspecialchars($d['password']); ?>" oninput="toggleLabel(this)">
                </div>

                <button type="submit" value="simpan">INPUT</button>
            </form>
        </div>
    </div>

</body>

</html>