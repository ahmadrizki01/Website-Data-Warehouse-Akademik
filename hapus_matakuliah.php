<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM dim_matakuliah WHERE id_Matakuliah='$id'");
header("location:data matakuliah.php");
?>