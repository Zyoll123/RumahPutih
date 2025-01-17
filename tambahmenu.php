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
        <?php include 'sidebar.php'; ?>
        <div class="isi">
            <div class="judul">
                <h1>Tambah Menu</h1>
            </div>

            <?php
            include 'konek.php';

            // Query untuk mengambil data kategori
            $query2 = "SELECT id_kategori, nama_kategori FROM kategori";
            $result2 = mysqli_query($conn, $query2);
            ?>

            <form method="post" action="tambah.php" enctype="multipart/form-data">
                <div class="form-grup">
                    <input type="text" class="form-input" id="nama" name="nama_produk" oninput="toggleLabel(this)">
                    <label for="nama" class="form-label">Masukkan Nama Produk</label>
                </div>

                <div class="form-grup">
                    <input type="text" class="form-input" id="harga" name="harga_produk" oninput="toggleLabel(this)">
                    <label for="harga" class="form-label">Masukkan Harga Produk</label>
                </div>

                <label class="custom-file-upload">
                    Masukkan Gambar Produk
                    <input type="file" class="file-input" id="fileUpload" name="gambar_produk" required />
                </label>
                <div class="file-name" id="fileName">Tidak ada file yang dipilih.</div><br>

                <!-- Select untuk memilih kategori -->
                <label for="id_kategori">Pilih Kategori:</label>
                <select name="id_kategori" id="id_kategori" required>
                    <option value="">--Pilih Kategori--</option>
                    <?php
                    // Loop dan tampilkan kategori dalam <option>
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<option value="' . $row['id_kategori'] . '">' . $row['nama_kategori'] . '</option>';
                    }
                    ?>
                </select>
                <br><br>

                <button type="submit">INPUT</button>
            </form>
        </div>
    </div>

    <script src="js/tambahmenu.js"></script>
</body>

</html>