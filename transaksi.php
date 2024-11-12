<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/transaksi.css">
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
                    <a href="#"><i class="fa-regular fa-file-lines"></i>History</a>
                </div>
                <div class="side-bar-item">
                    <a href="edit.php"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-solid fa-gear"></i>Setting</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-regular fa-user"></i>Profil</a>
                </div>
                <div class="log-out">
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
                </div>
            </div>
            <div class="formulir">
                <div class="judul-form">
                    <h2>Form Input Pelanggan</h2>
                </div>
                <div class="isi-form">
                    <form action="inpembeli.php" method="post">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" required><br><br>

                        <label for="no_meja">Nomor Meja:</label>
                        <input type="number" id="no_meja" name="no_meja" required><br><br>

                        <p>Metode Pembayaran:</p>

                        <?php
                        // Memasukkan file koneksi ke database
                        include 'konek.php';

                        // Menjalankan query untuk mengambil data metode pembayaran
                        $sql = "SELECT id_payment, nama_metode FROM payment";
                        $result = $conn->query($sql);

                        // Mengecek jika query berhasil dijalankan
                        if ($result) {
                            // Menampilkan metode pembayaran sebagai radio button jika data ditemukan
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<input type="radio" name="id_payment" value="' . $row['id_payment'] . '" required> ' . $row['nama_metode'] . '<br>';
                                }
                            } else {
                                echo 'Metode pembayaran tidak tersedia.';
                            }
                        } else {
                            // Menampilkan pesan error jika query gagal
                            echo 'Error: ' . $conn->error;
                        }

                        // Menutup koneksi ke database
                        $conn->close();
                        ?>

                        <br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>