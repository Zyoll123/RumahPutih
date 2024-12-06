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
        <?php include 'ksidebar.php'; ?>

        <div class="isi">
            <div class="judul">
                <h1>Edit Profile</h1>
            </div>

            <?php
            include 'konek.php';

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if ($_GET['role'] === 'admin') {
                    $query_produk = "SELECT * FROM admin WHERE id_admin = '$id'";
                } else {
                    $query_produk = "SELECT * FROM kasir WHERE id_kasir = '$id'";
                }                
                $result_produk = mysqli_query($conn, $query_produk);

                if ($result_produk && mysqli_num_rows($result_produk) > 0) {
                    $d = mysqli_fetch_assoc($result_produk);
                } else {
                    echo "Data pengguna tidak ditemukan.";
                    exit;
                }
            } else {
                echo "ID kasir tidak disediakan.";
                exit;
            }
            ?>

            <form method="post" action="updatekasir.php" enctype="multipart/form-data">
                <input type="hidden" name="id_kasir" value="<?php echo htmlspecialchars($d['id_kasir']); ?>">

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