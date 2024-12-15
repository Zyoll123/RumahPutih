<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
    .menu-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
        margin-left: 200px;
        margin-top: 20px;
        /* Memberikan jarak ke kiri */
    }

    .menu {
        text-align: center;
        border: 1px solid #ddd;
        background-color: #f8f8f8;
        border-radius: 5px;
        padding: 10px;
    }


    .menu-item img {
        width: 50%;
        height: auto;
        max-height: 50%;
        object-fit: cover;
    }

    .search-bar {
        text-align: center;
        margin-top: 100px;
    }

    .search-bar form {
        display: flex;
        margin-left: 230px;
        align-items: center;
        gap: 10px;
    }

    .search-bar input[type="text"] {
        width: 300px;
        padding: 12px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .search-bar input[type="text"]:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
    }

    .search-bar button {
        background-color: #4a97e4;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .search-bar button:hover {
        background-color: #9cc1e5;
        transform: scale(1.05);
    }

    .search-bar button i {
        margin-right: 5px;
        vertical-align: middle;
    }
</style>

<body>

    <body>
        <div class="container">
            <!-- Sidebar -->
            <div class="big-three">
                <?php include 'sidebar.php'; ?>
                <div class="tambah-menu">
                    <button><a href="tambahmenu.php"><i class="fa-solid fa-plus"></i> Tambah Menu</a></button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Cari menu..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit"><i class="fa fa-search"></i> Cari</button>
                </form>
            </div>

            <!-- Menu Container -->
            <div class="menu-container">
                <?php
                include 'konek.php';

                // Periksa koneksi ke database
                if (!$conn) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                // Ambil kata kunci pencarian
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Query produk berdasarkan pencarian
                $query = !empty($search) ? "SELECT * FROM produk WHERE nama_produk LIKE '%$search%'" : "SELECT * FROM produk";
                $data = mysqli_query($conn, $query);

                // Tampilkan data produk
                if (mysqli_num_rows($data) > 0) {
                    while ($d = mysqli_fetch_array($data)) {
                ?>
                        <div class="menu">
                            <div class="nama-menu">
                                <p><?php echo htmlspecialchars($d['nama_produk']); ?></p>
                                <div class="icon-edit">
                                    <a href="editmenu.php?id_produk=<?php echo $d['id_produk']; ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="hapus.php?id=<?php echo $d['id_produk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="menu-item">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo htmlspecialchars($d['nama_produk']); ?>">
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='no-data'>Tidak ada menu yang sesuai dengan pencarian Anda.</p>";
                }
                ?>
            </div>
        </div>
    </body>
</body>

</html>