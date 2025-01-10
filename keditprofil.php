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
                <h1>Edit Profile Kasir</h1>
            </div>

            <?php
            session_start();

            // Mengecek apakah pengguna sudah login
            if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
                header("Location: login.html");
                exit();
            }

            include 'konek.php'; // File koneksi database

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
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id_user);
                $stmt->execute();
                $result = $stmt->get_result();

                // Cek apakah data ditemukan
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                } else {
                    echo "Data tidak ditemukan.";
                    exit();
                }

                $stmt->close();
            } else {
                echo "Kesalahan query.";
                exit();
            }

            ?>

            <form method="post" action="kupdateadmin.php" enctype="multipart/form-data">
                <?php if ($_SESSION['role'] === 'admin') : ?>
                    <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($user['id_admin']); ?>">
                <?php elseif ($_SESSION['role'] === 'kasir') : ?>
                    <input type="hidden" name="id_kasir" value="<?php echo htmlspecialchars($user['id_kasir']); ?>">
                <?php endif; ?>

                <div class="form-grup">
                    <input type="text" class="form-input" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" name="no_telp" value="<?php echo htmlspecialchars($user['no_telp']); ?>" required>
                </div>

                <div class="form-grup">
                    <input type="password" class="form-input" name="password" placeholder="Masukkan password baru (opsional)">
                </div>

                <button type="submit">Simpan</button>
            </form>

        </div>
    </div>
</body>

</html>