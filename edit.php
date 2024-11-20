<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
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
            <div class="tambah-menu">
                <button><a href="tambahmenu.php"><i class="fa-solid fa-plus"></i>Tambah Menu</a></button>
            </div>
        </div>

        <?php 
        include 'konek.php';

        // Periksa koneksi ke database
        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        $data = mysqli_query($conn, "SELECT * FROM produk");

        // Periksa apakah ada data
        if (mysqli_num_rows($data) > 0) {
            while($d = mysqli_fetch_array($data)){
        ?>
        <div class="menu-container">
            <div class="menu">
                <div class="nama-menu">
                    <p><?php echo htmlspecialchars($d['nama_produk']); ?></p>
                    <div class="icon-edit">
                        <a href="editmenu.php?id_produk=<?php echo $d['id_produk']; ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="hapus.php?id=<?php echo $d['id_produk']; ?>"><i class="fa-regular fa-trash-can"></i></a>
                    </div>
                </div>
                <div class="menu-item">
                    <div class="gambar-menu">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo htmlspecialchars($d['nama_produk']); ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<p>Tidak ada produk yang tersedia.</p>";
        }
        ?>
    </div>
</body>

</html>
