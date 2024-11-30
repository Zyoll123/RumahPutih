<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "azizah_27");

// Check connection
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}

// Tambah data siswa
if (isset($_POST['tambah'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $address = $_POST['address'];

    // Menggunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("INSERT INTO siswa (nisn, nama, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nisn, $nama, $address);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Update data siswa
if (isset($_POST['update'])) {
    $nisn = $_POST['nisn'];
    $nomor = $_POST['nomor'];
    $nama = $_POST['nama'];
    $address = $_POST['address'];

    // Menggunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("UPDATE siswa SET nisn=?, nama=?, address=? WHERE nomor=?");
    $stmt->bind_param("sssi", $nisn, $nama, $address, $nomor);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data siswa
if (isset($_GET['hapus'])) {
    $nisn = $_GET['hapus'];

    // Menggunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("DELETE FROM siswa WHERE nomor=?");
    $stmt->bind_param("s", $nisn);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP dan MySQLi - db azizah_27</title>
    <style>
        body {
            background-color: #f4f4f4;
        }
        h2, p, h3 {
            text-align: center;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            height: 200px;
            justify-content: center;
            text-align: center;
            max-width: 400px;
            margin: auto;
        }
        .post {
            text-align: center;
            justify-content: center;
        }
        tr {
            background-color: #5cb85c;
        }
        td {
            background-color: white;
        }
    </style>
</head>
<body>
    <h2>CRUD DATA SISWA</h2>
    <p>Selamat datang, <?php echo $_SESSION['nama']; ?>!</p>
    <br>

    <!-- Form Tambah/Edit Data -->
    <?php
    // Jika form edit, tampilkan data sesuai NISN
    if (isset($_GET['edit'])) {
        $nomor = $_GET['edit'];
        $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE nomor=?");
        $stmt->bind_param("i", $nomor);
        $stmt->execute();
        $result = $stmt->get_result();
        $d = $result->fetch_assoc();
        $stmt->close();
    ?>
    <h3>EDIT DATA SISWA</h3>
    <form method="post" action="">
        <input type="hidden" name="nomor" value="<?php echo $d['nomor']; ?>">
        <table>
            <tr>
                <td>NISN</td>
                <td><input type="text" name="nisn" value="<?php echo $d['nisn']; ?>" readonly></td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td><input type="text" name="nomor" value="<?php echo $d['nomor']; ?>"></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" value="<?php echo $d['nama']; ?>"></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input type="text" name="address" value="<?php echo $d['address']; ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="update" value="UPDATE"></td>
            </tr>
        </table>
    </form>
    <?php
    } else {
    ?>
    <h3>TAMBAH DATA SISWA</h3>
<form method="post" action="">
    <table>
        <tr>
            <td>NISN</td>
            <td><input type="text" name="nisn" required></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" required></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type="text" name="address" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" style="background-color: #5cb85c;" name="tambah" value="TAMBAH"></td>
        </tr>
    </table>
</form>

    <?php
    }
    ?>

    <br/><br>

    <!-- Tabel Tampil Data -->
    <table border="1">
    <tr>
    <th>NO</th>
    <th>NISN</th>
    <th>Nama</th>
    <th>Address</th>
    <th>Opsi</th>
</tr>
<?php
$no = 1;
$result = $koneksi->query("SELECT * FROM siswa");
while ($d = $result->fetch_assoc()) {
?>
<tr>
    <td><?php echo $d['nomor']; ?></td>
    <td><?php echo $d['nisn']; ?></td>
    <td><?php echo $d['nama']; ?></td>
    <td><?php echo $d['address']; ?></td>
    <td>
        <a href="?edit=<?php echo $d['nomor']; ?>">EDIT</a> |
        <a href="?hapus=<?php echo $d['nomor']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">HAPUS</a>
    </td>
</tr>
<?php
}
?>
