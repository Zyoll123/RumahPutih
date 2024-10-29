<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="css/tambahmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="side-bar">
            <img src="assets/Logo Rumah Putih.png" alt="logo">
            <div class="side-bar-item">
                <a href="index.php"><i class="fa-solid fa-house"></i>Home Page</a>
            </div>
            <div class="side-bar-item">
                <a href="#"><i class="fa-regular fa-file-lines"></i>History</a>
            </div>
            <div class="side-bar-item">
                <a href="edit.html"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
            </div>
            <div class="side-bar-item">
                <a href="#"><i class="fa-solid fa-gear"></i>Setting</a>
            </div>
            <div class="side-bar-item">
                <a href="#"><i class="fa-regular fa-user"></i>Profil</a>
            </div>
            <div class="log-out">
                <a href="#"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
            </div>
        </div>
        <div class="isi">
            <div class="judul">
                <h1>Tambah Menu</h1>
            </div>

<?php  
include 'konek.php'; 

// Query untuk mengambil data kategori
$query2 = "SELECT id_kategori, nama_kategori FROM kategori";
$result2 = mysqli_query($conn, $query2);

$id_produk = $_GET['id_produk'];
$data = mysqli_query($conn,"select * from produk where id = '$id_produk'");
while($d = mysqli_fetch_array($data)){
?>

            <form method="post" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?php echo $d['id_produk'] ?>">
                <div class="form-grup">
                    <input type="text" class="form-input" id="nama" name="nama_produk" value="<?php echo $d['nama_produk'] ?>" oninput="toggleLabel(this)">
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" id="harga" name="harga_produk" value="<?php echo $d['harga_produk'] ?>" oninput="toggleLabel(this)">
                </div>

                <label class="custom-file-upload">
                    Masukkan Gambar Produk
                    <input type="file" class="file-input" id="fileUpload" name="gambar_produk" value="<?php echo $d['gambar_produk'] ?>" required/>
                </label>
                <div class="file-name" id="fileName">Tidak ada file yang dipilih.</div><br>

                <div class="form-grup">
                    <input type="text" class="form-input" id="stok" name="stok_produk" value="<?php echo $d['stok_produk'] ?>" oninput="toggleLabel(this)">
                </div>

                <!-- Select untuk memilih kategori -->
                <select name="id_kategori" id="id_kategori" required>
                <option value="<?php echo $d['id_kategori'] ?>">--Pilih Kategori--</option>
                <?php
                // Loop dan tampilkan kategori dalam <option>
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo '<option value="' . $row['id_kategori'] . '">' . $row['nama_kategori'] . '</option>';
                }
                ?>
            </select>
            <br><br>
                <button type="submit" value="simpan">INPUT</button>
            </form>
            <?php 
            }       
            ?>
        </div>
    </div>

    <script src="js/tambahmenu.js"></script>
</body>
</html>