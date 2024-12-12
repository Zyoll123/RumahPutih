<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/cobastyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
            <?php include 'ksidebar.php'; ?>
            <div class="order-information" style="margin-left: 250px;">
                <div class="mid-info">
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

                                <!-- Input uang yang dibayar -->
                                <label for="uang_dibayar">Uang Dibayar:</label>
                                <input type="number" id="uang_dibayar" name="uang_dibayar" required><br><br>

                                <h3>Pilih Produk</h3>
                                <?php
                                // Ambil daftar produk
                                $sql_produk = "SELECT * FROM produk";
                                $result_produk = $conn->query($sql_produk);
                                while ($row = $result_produk->fetch_assoc()) {
                                ?>
                                    <!-- echo "<div class='menu-item'>";
                                    echo "<p>{$row['nama_produk']} - Rp {$row['harga_produk']}</p>";
                                    echo "<input type='hidden' name='produk[{$row['id_produk']}]' value='{$row['id_produk']}'>";
                                    echo "<input type='number' name='quantity[{$row['id_produk']}]' value='0' min='0' max='100' placeholder='Jumlah' required><br>";
                                    echo "</div><br>"; -->
                                    <div class="menu-container">
                                        <div class="menu">
                                            <p><?php echo $row['nama_produk']; ?></p>
                                            <div class="menu-item">
                                                <img src="data:image/jpg;base64,<?php echo base64_encode($row['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                                                <div class="menu-info">
                                                    <p>Rp <?php echo $row['harga_produk']; ?></p>
                                                        <input type="hidden" name="produk[<?php echo $row['id_produk']; ?>]" value="<?php echo $row['id_produk']; ?>">
                                                        <div class="input-number-container">
                                                            <button type="button" class="minusBtn">-</button>
                                                            <input type="number" class="numberInput" name="quantity[<?php echo $row['id_produk']; ?>]" value="0" min="0" max="1000" required>
                                                            <button type="button" class="plusBtn">+</button>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <input type="submit" value="Submit">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="js/script.js"></script>
</body>

</html>