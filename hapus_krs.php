<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Jalankan query hapus
$hapus = mysqli_query($koneksi, "DELETE FROM fact_krs WHERE id_krs = '$id'");

if($hapus){
    // Jika berhasil, kembali ke halaman data
    header("location:lihat data krs.php?status=sukses&pesan=Data Berhasil Dihapus");
}else{
    // Jika gagal
    echo "Gagal menghapus data!";
}
?>