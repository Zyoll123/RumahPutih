<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>
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
                <a href="#"><i class="fa-regular fa-file-lines"></i>History</a>
            </div>
            <div class="side-bar-item">
                <a href="edit.php"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
            </div>
            <div class="side-bar-item">
                <a href="setting.php"><i class="fa-solid fa-gear"></i>Setting</a>
            </div>
            <div class="side-bar-item">
                <a href="#"><i class="fa-regular fa-user"></i>Profil</a>
            </div>
            <div class="log-out">
                <a href="login.html"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
            </div>
        </div>

        <div class="isi">
            <div class="judul">
                <h1>Edit Kasir</h1>
            </div>

            <?php
            include 'konek.php';

            if (isset($_GET['id_kasir'])) {
                $id_kasir = $_GET['id_kasir'];
                
                // Query untuk mengambil data kasir berdasarkan id_kasir
                $query_kasir = "SELECT * FROM kasir WHERE id_kasir = '$id_kasir'";
                $result_kasir = mysqli_query($conn, $query_kasir);

                if ($result_kasir && mysqli_num_rows($result_kasir) > 0) {
                    $d = mysqli_fetch_assoc($result_kasir);
                } else {
                    echo "<p>Data kasir tidak ditemukan.</p>";
                    exit;
                }
            } else {
                echo "<p>ID kasir tidak disediakan.</p>";
                exit;
            }
            ?>

            <form method="post" action="updatekasir.php" enctype="multipart/form-data">
                <input type="hidden" name="id_kasir" value="<?php echo htmlspecialchars($d['id_kasir']); ?>">
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-input" id="username" name="username" value="<?php echo htmlspecialchars($d['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_telp">No. Telp</label>
                    <input type="text" class="form-input" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($d['no_telp']); ?>" required>
                </div>

                <button type="submit" value="simpan">INPUT</button>
            </form>
        </div>
    </div>

    <script src="js/tambahmenu.js"></script>
</body>

</html>
