<?php

include 'konek.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "INSERT INTO kasir (username, no_telp, password) VALUES ('username', 'no_telp', 'password')";

if (mysqli_query($conn, $query)) {
    echo "Kasir berhasil ditambahkan!";
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>