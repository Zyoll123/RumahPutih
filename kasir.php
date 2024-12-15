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

    .search-container {
        display: flex;
        justify-content: center;
        position: fixed;
        padding-top: 20px;
        width: 800px;
        height: 55px;
        background-color: #ffff;
        margin-left: 202px;
    }

    .form-grup {
        position: relative;
        margin-bottom: 20px;
    }

    .form-input {
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        font-size: 16px;
    }

    .form-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 0 5px;
        pointer-events: none;
        transition: 0.2s ease all;
        color: #999;
        font-size: 16px;
    }

    .hidden {
        opacity: 0;
        visibility: hidden;
        transition: visibility 0.2s, opacity 0.2s ease;
    }

    .order-information {
        position: absolute;
        left: 230px;
    }

    .isi-form {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        /* Kurangi jarak antar elemen */
        margin-top: 5px;
        /* Kurangi margin atas */
    }

    .form-nama {
        width: 48%;
        margin-top: 10px;
    }

    .form-dibayar {
        width: 48%;
        margin-left: 550px;
        margin-top: -90px;
    }

    .form-meja {
        width: 48%;
    }

    form label,
    form input,
    form select,
    form h2 {
        display: block;
        margin-bottom: 3px;
        /* Kurangi margin bawah */
    }

    form input,
    form select {
        width: 100%;
        padding: 6px;
        /* Kurangi padding */
        border: 1px solid #ccc;
        /* Gunakan warna border lebih lembut */
        border-radius: 3px;
        /* Kurangi radius border */
    }

    .logo-info {
        display: flex;
        justify-content: flex-start;
    }

    .logo-info img {
        height: 50px;
        margin-top: 15px;
        margin-left: 20px;
    }

    .kasir-info {
        margin-top: 20px;
        margin-left: 20px;
    }

    .kasir-info p {
        margin: 3px;
    }


    .radio-place {
        display: flex;
        justify-content: space-evenly;
        margin: 10px;
    }

    input[type="radio"] {
        display: none;
    }

    .custom-radio {
        display: inline-block;
        padding: 10px 20px;
        background-color: #f1f1f1;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid transparent;
        font-weight: normal;
        /* Normal weight by default */
        transition: background-color 0.3s, border-color 0.3s;
    }

    input[type="radio"]:checked+label {
        background-color: #9cc1e5;
        color: white;
        font-weight: bold;
        border-color: #9cc1e5;
    }

    .custom-radio:hover {
        background-color: #ddd;
    }

    .buttom-info {
        display: flex;
        justify-content: flex-end;
        margin-top: 40px;
        margin-right: 20px;
    }

    .buttom-info button {
        height: 30px;
        width: 120px;
        background-color: #ddd;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid transparent;
        font-weight: normal;
        /* Normal weight by default */
        transition: background-color 0.3s, border-color 0.3s;
    }

    .buttom-info button:hover {
        background-color: #9cc1e5;
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* Tiga kolom */
        grid-auto-rows: minmax(250px, auto);
        /* Tinggi minimum setiap baris */
        gap: 30px;
        /* Jarak antar elemen */
        margin: 10px;
        max-width: 930px;
        /* Sesuaikan lebar sesuai kebutuhan */
        margin-left: auto;
        margin-right: auto;
    }

    .menu {
        display: inline;
        width: 310px;
        height: 250px;
        background-color: #ffff;
        border-radius: 10px;
        margin-top: 10px;
    }

    .menu p {
        margin-top: 20px;
        margin-left: 30px;
        font-size: 20px;
    }

    .menu-item {
        display: flex;
        justify-content: space-evenly;
        margin-top: 10px;

    }

    .menu-item p {
        font-size: 18px;
        margin-left: 0;
    }

    .menu-info {
        display: inline;
    }

    .menu-info p {
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .input-number-container {
        display: flex;
        align-items: center;
        /* Tengahkan vertikal */
        justify-content: center;
        /* Tengahkan horizontal */
        gap: 5px;
        /* Beri jarak antar elemen */
    }

    .input-number-container button {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    .input-number-container .numberInput {
        width: 40px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }


    /* Untuk browser WebKit (Chrome, Safari, Opera) */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* .button input {
        margin-bottom: 20px;
        justify-content: center;
    } */

    .submit-button {
        display: flex;
        justify-content: space-around;
        position: fixed;
        height: 50px;
        width: 100%;

        bottom: 0;
    }

    .submit-button input {
        display: flex;
        justify-content: flex-end;
        width: 100px;
        height: 40px;
        margin: 10px auto;
        background-color: #3498db;
        /* Warna biru cerah */
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 1030px;
    }

    .submit-button input:hover {
        background-color: #2980b9;
        /* Warna biru lebih gelap saat hover */
        transform: scale(1.05);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    <div class="container">
        <div class="big-three">
            <?php include 'ksidebar.php'; ?>
            <div class="order-information">
                <div class="mid-info">
                    <div class="isi-form">
                        <form action="inpembeli.php" method="post">
                            <div class="form-nama">
                                <label for="nama">Nama:</label>
                                <input type="text" id="nama" name="nama" required><br><br>
                            </div>

                            <div class="form-dibayar">
                                <!-- Input uang yang dibayar -->
                                <label for="uang_dibayar">Uang Dibayar:</label>
                                <input type="number" id="uang_dibayar" name="uang_dibayar" required><br><br>
                            </div>

                            <div class="form-meja">
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
                            </div>

                            <h3>Pilih Produk</h3>
                            <div class="menu-container">
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

                                <?php
                                }
                                ?>
                            </div>

                            <div class="total-harga">
                                <h3>Total Harga: Rp <span id="totalHarga">0</span></h3>
                            </div>

                            <div class="submit-button">
                                <input type="submit" value="Submit">
                            </div>
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