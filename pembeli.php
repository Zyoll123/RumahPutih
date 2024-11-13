<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="css/editKP.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="big-three">
            <div class="side-bar">
                <img src="assets/Logo Rumah Putih.png" alt="logo">
                <div class="side-bar-item">
                    <a href="#"><i class="fa-solid fa-house"></i>Home Page</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-regular fa-file-lines"></i>History</a>
                </div>
                <div class="side-bar-item">
                    <a href="edit.php"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
                </div>
                <div class="side-bar-item">
                    <a href="setting.php"><i class="fa-solid fa-gear"></i>Setting</a>
                </div>
                <div class="side-bar-item">
                    <a href="#"><i class="fa-regular fa-user"></i>Profil</a>
                </div>
                <div class="log-out">
                    <a href="login.html"><i class="fa-solid fa-right-from-bracket"></i>Log Out</a>
                </div>
            </div>
        </div>
        <div class="tabel">
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Meja</th>
                </tr>
                <?php 
                include 'konek.php';
                $no = 1;

                $result = $conn->query("SELECT * FROM pembeli");

                while ($d = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['nama']; ?></td>
                    <td><?php echo $d['no_meja']; ?></td>
                    <td>
                        <a href=""></a>
                        <a href=""></a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>