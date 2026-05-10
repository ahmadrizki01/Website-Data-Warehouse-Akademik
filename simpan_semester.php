<?php
// Hubungkan ke database
include 'koneksi.php';

// Ambil data dari form
$id_semester = $_POST['id_semester'];
$semester = $_POST['semester'];
$tahun_ajaran = $_POST['tahun_ajaran'];

// Query untuk menyimpan data
$query = "INSERT INTO dim_semester (id_semester, semester, tahun_ajaran) 
          VALUES ('$id_semester', '$semester', '$tahun_ajaran')";

// Eksekusi query
if(mysqli_query($koneksi, $query)) {
    // Jika berhasil, kembali ke halaman data semester
    echo "<script>alert('Data Berhasil Disimpan!'); window.location='data semester.php';</script>";
} else {
    // Jika gagal
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

?>