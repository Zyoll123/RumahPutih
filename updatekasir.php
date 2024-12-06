<?php
include 'konek.php';

$id_kasir = $_POST['id_kasir'];
$username = $_POST['username'];
$no_telp = $_POST['no_telp'];

$query = "UPDATE kasir SET 
                username='$username',
                no_telp='$no_telp'
              WHERE id_kasir'$id_kasir'";

if (mysqli_query($conn, $query)) {
    header("Location: kprofil.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>
