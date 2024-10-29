<?php  

include 'konek.php';

$id = $_GET['id_produk'];

mysqli_query($conn,"delete from produk where id_produk='$id'");

header("location: edit.php");

?>