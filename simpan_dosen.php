<?php
// Hubungkan ke database
include 'koneksi.php';

// Ambil data dari form
$id_dosen = $_POST['id_dosen'];
$nama_dosen = $_POST['nama_dosen'];
$jabatan = $_POST['jabatan'];

// Query untuk menyimpan data
$query = "INSERT INTO dim_dosen (id_dosen, nama_dosen, jabatan) 
          VALUES ('$id_dosen', '$nama_dosen', '$jabatan')";

// Eksekusi query
if(mysqli_query($koneksi, $query)) {
    // Jika berhasil, kembali ke halaman data dosen
    echo "<script>alert('Data Berhasil Disimpan!'); window.location='data dosen.php';</script>";
} else {
    // Jika gagal
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

?>