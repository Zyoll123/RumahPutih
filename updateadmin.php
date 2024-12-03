<?php
include 'konek.php';

$id_admin = $_POST['id_admin'];
$username = $_POST['username'];
$no_telp = $_POST['no_telp'];

$query = "UPDATE admin SET 
                username='$username',
                no_telp='$no_telp'
              WHERE id_admin='$id_admin'";

if (mysqli_query($conn, $query)) {
    header("Location: profil.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>
