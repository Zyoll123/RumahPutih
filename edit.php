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
            <div class="side-bar">
                <img src="assets/Logo Rumah Putih.png" alt="logo">
                <div class="side-bar-item">
                    <a href="index.php"><i class="fa-solid fa-house"></i>Home Page</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-regular fa-file-lines"></i>History</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
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
            <div class="tambah-menu">
                <button><i class="fa-solid fa-plus"><a href="tambahmenu.php">Tambah Menu</a></i></button>
            </div>
        </div>
        <?php 
        include 'konek.php';
        $data = mysqli_query($conn, "SELECT * FROM produk");
        while($d = mysqli_fetch_array($data)){
        ?>
        <div class="menu-container">
            <div class="menu">
                <div class="nama-menu">
                    <p><?php echo $d['nama_produk'] ?></p>
                    <div class="icon-edit">
                        <a href="editmenu.php"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="hapus.php"><i class="fa-regular fa-trash-can"></i></a>
                    </div>
                </div>
                <div class="menu-item">
                    <div class="gambar-menu">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($d['gambar_produk']); ?>" alt="<?php echo $d['nama_produk']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php 
         }
        ?>
    </div>
</body>

</html>