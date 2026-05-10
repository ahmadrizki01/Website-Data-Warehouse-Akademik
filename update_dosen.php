<?php
include 'koneksi.php';

// Ambil data dari form
$id_dosen = $_POST['id_dosen'];
$nama_dosen = $_POST['nama_dosen'];
$jabatan = $_POST['jabatan'];

// Query untuk mengupdate data
$query = mysqli_query($koneksi, "UPDATE dim_dosen SET 
    nama_dosen = '$nama_dosen', 
    jabatan = '$jabatan' 
    WHERE id_dosen = '$id_dosen'");

// Cek apakah berhasil atau tidak
if($query){
    // Jika berhasil, kembali ke halaman data dosen
    header("location:data dosen.php?status=sukses&pesan=Data Berhasil Diupdate");
}else{
    // Jika gagal
    echo "Gagal mengupdate data!";
}
?>