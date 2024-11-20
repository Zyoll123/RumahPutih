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
            <div class="formulir">
                <div class="judul-form">
                    <h2>Form Input Pelanggan</h2>
                </div>
                <div class="isi-form">
                    <form action="inpembeli.php" method="post">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" required><br><br>

                        <?php
                        include 'konek.php';

                        // Query untuk mengambil data meja
                        $sql = "SELECT no_meja, status_meja FROM meja";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<h2>Daftar Meja</h2>";
                            echo "<table border='1'>
        <tr>
            <th>Nomor Meja</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
            <td>" . htmlspecialchars($row['no_meja']) . "</td>
            <td>" . htmlspecialchars($row['status_meja']) . "</td>";
                                if ($row['status_meja'] == 'kosong') {
                                    echo "<td><a href='ubah_status_meja.php?no_meja=" . $row['no_meja'] . "&status=terisi'>Tandai Terisi</a></td>";
                                } else {
                                    echo "<td><a href='ubah_status_meja.php?no_meja=" . $row['no_meja'] . "&status=kosong'>Tandai Kosong</a></td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Tidak ada data meja.";
                        }

                        $conn->close();
                        ?>




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