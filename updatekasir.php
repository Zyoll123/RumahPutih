<?php
include 'konek.php';

$id_kasir = $_POST['id_kasir'];
$username = $_POST['username'];
$no_telp = $_POST['no_telp'];

// Mencegah SQL Injection dengan mysqli_real_escape_string
$id_kasir = mysqli_real_escape_string($conn, $id_kasir);
$username = mysqli_real_escape_string($conn, $username);
$no_telp = mysqli_real_escape_string($conn, $no_telp);

// Perbaiki query SQL
$query = "UPDATE kasir SET 
                username='$username',
                no_telp='$no_telp'
              WHERE id_kasir='$id_kasir'";  // Perbaikan pada WHERE clause

if (mysqli_query($conn, $query)) {
    header("Location: setting.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>
