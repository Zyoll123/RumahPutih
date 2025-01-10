<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>
    <link rel="stylesheet" href="css/tambahmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #dde9dd;
    }

    .big-three {
        display: flex;
        justify-content: flex-start;
    }

    .side-bar {
        display: inline;
        position: fixed;
        height: 100%;
        width: 200px;
        background-color: #ffff;
        border-right: 1px solid #979494;
        left: 0;
    }

    .side-bar img {
        width: 150px;
        margin: 20px;
    }

    .side-bar-item {
        margin-top: 5px;
        margin-bottom: 30px;
        margin-left: 20px;
    }

    .side-bar-item:hover a {
        color: #9cc1e5;
    }

    .side-bar-item a {
        text-decoration: none;
        color: black;
    }

    .side-bar-item a i {
        margin-right: 10px;
    }

    .log-out {
        margin-top: 170px;
        margin-left: 20px;
    }

    .log-out:hover a {
        color: #9cc1e5;
    }

    .log-out a {
        text-decoration: none;
        color: black;
    }

    .log-out a i {
        margin-right: 10px;
    }

    .isi {
        margin-left: 220px;
        padding: 10px;
        width: calc(100% - 240px);
        /* Menyesuaikan lebar agar fleksibel */
        max-width: 700px;
        /* Membatasi lebar maksimum */
        height: auto;
        /* Menyesuaikan tinggi dengan konten */
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 150px;
    }

    .judul {
        text-align: center;
        margin-left: 230px;
        background-color: #41729F;
        padding: 10px;
        border-radius: 5px;
        width: 200px;
        height: 40px;
    }

    .judul h1 {
        color: white;
    }

    form {
        max-width: 700px;
        margin-bottom: 80px;
    }

    .form-group {
        margin-bottom: 20px;
        margin-right: 180px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
    }

    .form-input:focus {
        border-color: #9cc1e5;
    }

    button[type="submit"] {
        display: block;
        width: 200px;
        padding: 10px;
        margin-left: 70px;
        font-size: 18px;
        color: white;
        background-color: #41729F;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #41729F;
    }

    .error-message {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

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

                <button type="submit" value="simpan" style="color:white">INPUT</button>
            </form>
        </div>
    </div>

</body>

</html>