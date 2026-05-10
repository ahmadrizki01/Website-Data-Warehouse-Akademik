<?php
// Hubungkan ke database
include 'koneksi.php';

// Ambil data dari form
$id_Matakuliah = $_POST['id_Matakuliah'];
$nama_Matakuliah = $_POST['nama_Matakuliah'];
$sks = $_POST['sks'];
$semester = $_POST['semester'];

// Query untuk menyimpan data
$query = "INSERT INTO dim_matakuliah (id_Matakuliah, nama_Matakuliah, sks, semester) 
          VALUES ('$id_Matakuliah', '$nama_Matakuliah', '$sks', '$semester')";

// Eksekusi query
if(mysqli_query($koneksi, $query)) {
    // Jika berhasil, kembali ke halaman data matakuliah
    echo "<script>alert('Data Berhasil Disimpan!'); window.location='data matakuliah.php';</script>";
} else {
    // Jika gagal
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

?>