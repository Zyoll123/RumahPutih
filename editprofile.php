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
        <?php include 'sidebar.php'; ?>

        <div class="isi">
            <div class="judul">
                <h1>Edit Profile Admin</h1>
            </div>

            <?php
            include 'konek.php';

            // Validasi ID dan role
            if (isset($_GET['id']) && $_GET['role'] === 'admin') {
                $id_admin = $_GET['id'];

                // Query untuk mengambil data admin
                $query = "SELECT * FROM admin WHERE id_admin = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_admin);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $d = $result->fetch_assoc();
                } else {
                    echo "Data admin tidak ditemukan.";
                    exit;
                }
            } else {
                echo "ID atau role tidak valid.";
                exit;
            }
            ?>

            <form method="post" action="updateadmin.php" enctype="multipart/form-data">
                <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($d['id_admin']); ?>">

                <div class="form-grup">
                    <input type="text" class="form-input" name="username" value="<?php echo htmlspecialchars($d['username']); ?>" required>
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" name="no_telp" value="<?php echo htmlspecialchars($d['no_telp']); ?>" required>
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
