<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM dim_dosen WHERE id_dosen='$id'");
header("location:data dosen.php");
?>