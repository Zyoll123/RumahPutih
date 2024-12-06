<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
        <?php include 'sidebar.php';?>
            <div class="tambah-menu">
                <button><a href="tambahmenu.php"><i class="fa-solid fa-plus"></i>Tambah Menu</a></button>
            </div>
        </div>

        <?php
        include 'konek.php';

        // Periksa koneksi ke database
        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        $data = mysqli_query($conn, "SELECT * FROM produk");

        // Periksa apakah ada data
        if (mysqli_num_rows($data) > 0) {
            while ($d = mysqli_fetch_array($data)) {
        ?>
                <div class="menu-container" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between;">
                    <div class="menu" style="flex: 0 0 calc(50% - 10px); box-sizing: border-box; padding: 10px; text-align: center; border: 1px solid #ddd; background-color: #f8f8f8; border-radius: 5px;">
                        <div class="nama-menu">
                            <p><?php echo htmlspecialchars($d['nama_produk']); ?></p>
                            <div class="icon-edit">
                                <a href="editmenu.php?id_produk=<?php echo $d['id_produk']; ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="hapus.php?id=<?php echo $d['id_produk']; ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="gambar-menu">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo htmlspecialchars($d['nama_produk']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>Tidak ada produk yang tersedia.</p>";
        }
        ?>
    </div>
</body>

</html>