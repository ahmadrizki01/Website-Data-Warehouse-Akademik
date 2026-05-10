<?php
include 'koneksi.php';

// Ambil data dari form
$id_semester = $_POST['id_semester'];
$semester = $_POST['semester'];
$tahun_ajaran = $_POST['tahun_ajaran'];

// Query update data
$query = mysqli_query($koneksi, "UPDATE dim_semester SET 
    semester = '$semester', 
    tahun_ajaran = '$tahun_ajaran' 
    WHERE id_semester = '$id_semester'");

// Cek status
if($query){
    header("location:data semester.php?status=sukses&pesan=Data Berhasil Diupdate");
}else{
    echo "Gagal mengupdate data!";
}
?>