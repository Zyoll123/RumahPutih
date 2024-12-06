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
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="tabel">
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
                <?php
                include 'konek.php';
                $no = 1;

                $result = $conn->query("SELECT * FROM kasir");

                if ($result) {
                    while ($d = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($d['username']); ?></td>
                            <td><?php echo htmlspecialchars($d['no_telp']); ?></td>
                            <td>
                                <a href="editkasir.php?id_kasir=<?php echo $d['id_kasir']; ?>">EDIT</a>
                                <a href="hapuskasir.php?id_kasir=<?php echo $d['id_kasir']; ?>">HAPUS</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data kasir.</td></tr>";
                }
                ?>
            </table>
            <br>
            <a href="sign-up.html">tambah kasir</a>
        </div>
    </div>
</body>

</html>