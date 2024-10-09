<?php

$severname = "localhost";
$username = "root";
$password = "";
$dbname = "rumahputih"

$conn = new mysqli($severname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

?>