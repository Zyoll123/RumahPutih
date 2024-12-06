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
            <?php include 'ksidebar.php'; ?>
            <div class="formulir">
                <div class="judul-form">
                    <h2>Form Input Pelanggan</h2>
                </div>
                <div class="isi-form">
                    <form action="inpembeli.php" method="post">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" required><br><br>

                        <!-- Daftar Meja -->
                        <h2>Daftar Meja</h2>
                        <?php
                        include 'konek.php';

                        $sql = "SELECT no_meja, status_meja FROM meja";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '<label for="no_meja">Pilih Meja:</label>';
                            echo '<select id="no_meja" name="no_meja" required>';
                            while ($row = $result->fetch_assoc()) {
                                $status = htmlspecialchars($row['status_meja']);
                                $disabled = $status === 'terisi' ? 'disabled' : '';
                                echo '<option value="' . $row['no_meja'] . '" ' . $disabled . '>Meja ' . $row['no_meja'] . ' (' . $status . ')</option>';
                            }
                            echo '</select><br><br>';
                        } else {
                            echo 'Tidak ada meja tersedia.';
                        }
                        ?>

                        <!-- Metode Pembayaran -->
                        <p>Metode Pembayaran:</p>
                        <?php
                        $sql = "SELECT id_payment, nama_metode FROM payment";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<input type="radio" name="id_payment" value="' . $row['id_payment'] . '" required> ' . $row['nama_metode'] . '<br>';
                            }
                        } else {
                            echo 'Metode pembayaran tidak tersedia.';
                        }

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