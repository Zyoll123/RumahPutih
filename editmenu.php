<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="css/tambahmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="isi">
            <div class="judul">
                <h1>Edit Menu</h1>
            </div>

            <?php
            include 'konek.php';

            // Cek apakah 'id_produk' ada di URL
            if (isset($_GET['id_produk'])) {
                $id_produk = $_GET['id_produk'];

                // Query untuk mengambil data produk berdasarkan id_produk
                $query_produk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
                $result_produk = mysqli_query($conn, $query_produk);

                // Jika produk ditemukan
                if ($result_produk && mysqli_num_rows($result_produk) > 0) {
                    $d = mysqli_fetch_assoc($result_produk);
                } else {
                    echo "Data produk tidak ditemukan.";
                    exit;
                }

                // Query untuk mengambil data kategori
                $query_kategori = "SELECT id_kategori, nama_kategori FROM kategori";
                $result_kategori = mysqli_query($conn, $query_kategori);

                if (!$result_kategori) {
                    die("Query kategori gagal: " . mysqli_error($conn));
                }
            } else {
                echo "ID produk tidak disediakan.";
                exit;
            }
            ?>

            <form method="post" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($d['id_produk']); ?>">

                <div class="form-grup">
                    <input type="text" class="form-input" id="nama" name="nama_produk" value="<?php echo htmlspecialchars($d['nama_produk']); ?>" oninput="toggleLabel(this)">
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" id="harga" name="harga_produk" value="<?php echo htmlspecialchars($d['harga_produk']); ?>" oninput="toggleLabel(this)">
                </div>

                <img src="data:image/jpeg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="Gambar Produk Lama" style="width:200px;height:150px;padding:10px;">
                <label class="custom-file-upload">
                    Ganti Gambar Produk
                    <input type="file" class="file-input" id="fileUpload" name="gambar_produk_baru">
                </label>
                <div class="file-name" id="fileName">Tidak ada file yang dipilih.</div><br>

                <button type="submit" value="simpan">INPUT</button>
            </form>
        </div>
    </div>

    <script src="js/tambahmenu.js"></script>
</body>

</html>