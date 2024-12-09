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
            <?php include 'ksidebar.php';?>
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
                            <p>id:</p>
                        </div>
                    </div>
                </div>
                <div class="mid-info">
                    <h3>Order : </h3>
                    <div class="radio-place">
                        <input type="radio" id="pilihan-1" name="place" value="pilihan-1">
                        <label for="pilihan-1" class="custom-radio">Dine In</label>
                        <input type="radio" id="pilihan-2" name="place" value="pilihan-2">
                        <label for="pilihan-2" class="custom-radio">Take Away</label>
                    </div>
                    <p>Tanggal : </p>
                </div>
                <div class="buttom-info">
                    <a href="ktransaksi.php">Place On Order</a>
                </div>
            </div>
        </div>
        <div class="menu-juga">
            <?php
            include 'konek.php';

            // Tangkap input pencarian
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Query pencarian
            $query = "SELECT * FROM produk WHERE nama_produk LIKE '%$search%'";
            $data = mysqli_query($conn, $query);

            // Tampilkan hasil pencarian
            if (mysqli_num_rows($data) > 0) {
                while ($d = mysqli_fetch_array($data)) {
            ?>
                    <div class="menu-container">
                        <div class="menu">
                            <p><?php echo $d['nama_produk']; ?></p>
                            <div class="menu-item">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                                <div class="menu-info">
                                    <p>Rp <?php echo $d['harga_produk']; ?></p>
                                    <div class="input-number-container">
                                        <button class="minusBtn">-</button>
                                        <input type="number" class="numberInput" value="0" min="0" max="1000">
                                        <button class="plusBtn">+</button>
                                    </div>
                                    <div class="tambah">
                                        <br>
                                        <button class="input">tambah produk</button>
                                    </div>
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