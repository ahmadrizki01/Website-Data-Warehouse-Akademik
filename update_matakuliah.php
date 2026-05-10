<?php
include 'koneksi.php';

// Ambil data dari form
$id_Matakuliah = $_POST['id_Matakuliah'];
$nama_Matakuliah = $_POST['nama_Matakuliah'];
$sks = $_POST['sks'];
$semester = $_POST['semester'];

// Query update data
$query = mysqli_query($koneksi, "UPDATE dim_matakuliah SET 
    nama_Matakuliah = '$nama_Matakuliah', 
    sks = '$sks', 
    semester = '$semester' 
    WHERE id_Matakuliah = '$id_Matakuliah'");

// Cek status
if($query){
    header("location:data matakuliah.php?status=sukses&pesan=Data Berhasil Diupdate");
}else{
    echo "Gagal mengupdate data!";
}
?>