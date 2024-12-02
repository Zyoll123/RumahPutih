<?php
session_start();
if (!isset($_SESSION['id_kasir'])) {
    header("Location: ../login.html");
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
            <div class="side-bar">
                <img src="../assets/Logo Rumah Putih.png" alt="logo">
                <div class="side-bar-item">
                    <a href="user.php"><i class="fa-solid fa-house"></i>Home Page</a>
                </div>
                <div class="side-bar-item">
                    <a href="history.php"><i class="fa-regular fa-file-lines"></i>History</a>
                </div>
                <div class="side-bar-item">
                    <a href="profil.php"><i class="fa-regular fa-user"></i>Profil</a>
                </div>
                <div class="log-out">
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
                </div>
            </div>
            <div class="search-container">
                <div class="form-grup">
                    <input type="text" class="form-input" id="search-input" oninput="toggleLabel(this)">
                    <label for="search-input" class="form-label">Search Menu</label>
                </div>
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
                    <a href="transaksi.php">Place On Order</a>
                </div>
            </div>
        </div>
        <?php
        include 'konek.php';
        $data = mysqli_query($conn, "SELECT * FROM produk");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <div class="menu-container">
                <div class="menu">
                    <p><?php echo $d['nama_produk'] ?></p>
                    <div class="menu-item">
                        <!-- Menampilkan gambar BLOB sebagai base64 -->
                        <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                        <div class="menu-info">
                            <p><?php echo $d['harga_produk'] ?></p>
                            <div class="input-number-container">
                                <button class="minusBtn">-</button>
                                <input type="number" class="numberInput" value="0" min="0" max="1000">
                                <button class="plusBtn">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <script src="js/script.js"></script>
</body>

</html>