<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "azizah_27");

// Check connection
if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <style>
        table{
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1{
            text-align: center;
        }
        tr{
            background-color: #5cb85c;
            width:150px;
            text-align: center;
        }
        td{
            background-color: white;
            width: 150px;
            text-align: center;
        }
        form{
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        input, button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <h1>SELAMAT DATANG USER</h1>
    <table border="1">
        <tr>
            <th>NO</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Address</th>
        </tr>
        <?php
        $no = 1;
        $result = $koneksi->query("SELECT * FROM siswa");
        if ($result) {
            while($d = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['nisn']; ?></td>
            <td><?php echo $d['nama']; ?></td>
            <td><?php echo $d['address']; ?></td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
        }
        ?>
    </table>

    <!-- Form untuk menambah data siswa -->
    <form method="POST" action="">
        <input type="text" name="nisn" placeholder="NISN" required>
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="tambah">Tambah Data</button>
    </form>

    <?php
    if (isset($_POST['tambah'])) {
        $nisn = $_POST['nisn'];
        $nomor = $_POST['nomor'];
        $nama = $_POST['nama'];
        $address = $_POST['address'];

        // Menggunakan prepared statement untuk keamanan
        $stmt = $koneksi->prepare("INSERT INTO siswa (nisn, nomor, nama, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nisn, $nomor, $nama, $address);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    ?>
</body>
</html>
