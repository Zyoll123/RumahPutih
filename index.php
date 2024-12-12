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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
            <?php include 'sidebar.php'; ?>
            <div class="search-container">
                <form method="GET" action="">
                    <div class="form-grup">
                        <input type="text" class="form-input" id="search-input" name="search" placeholder="Search Menu" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="order-information">
                <div class="top-info">
                    <div class="logo-info">
                        <img src="assets/Rectangle.png" alt="">
                        <div class="kasir-info">
                            <p><?php echo $_SESSION['username']; ?></p>
                            <p>id: <?php echo $_SESSION['id']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="mid-info">
                    <p>Tanggal : <?php echo date("d-m-Y"); ?></p>
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

                                $conn->close();
                                ?>

                                <br>
                                <input type="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="buttom-info">
                    <a href="transaksi.php">Place On Order</a>
                </div>
            </div>
        </div>
        <div class="menu-juga">
            <?php

            include 'konek.php';
            // Tangkap input pencarian
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Query pencarian
            $query = "SELECT * FROM produk WHERE nama_produk LIKE ?";
            $stmt_search = $conn->prepare($query);
            $search_param = "%" . $search . "%";
            $stmt_search->bind_param("s", $search_param);
            $stmt_search->execute();
            $data = $stmt_search->get_result();

            // Tampilkan hasil pencarian
            if ($data->num_rows > 0) {
                while ($d = $data->fetch_assoc()) {
            ?>
                    <div class="menu-container">
                        <div class="menu">
                            <p><?php echo $d['nama_produk']; ?></p>
                            <div class="menu-item">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                                <div class="menu-info">
                                    <p>Rp <?php echo $d['harga_produk']; ?></p>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_produk" value="<?php echo $d['id_produk']; ?>">
                                        <div class="input-number-container">
                                            <button type="button" class="minusBtn">-</button>
                                            <input type="number" class="numberInput" name="quantity" value="0" min="0" max="1000">
                                            <button type="button" class="plusBtn">+</button>
                                        </div>
                                        <button type="submit" name="add_product" class="input">Tambah Produk</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p style='text-align: center; color: gray;'>Hasil tidak ditemukan.</p>";
            }
            ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>