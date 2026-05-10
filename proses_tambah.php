<?php
// Panggil koneksi
include 'koneksi.php';

// Tangkap data dari form
$nama = $_POST['nama'];
$prodi = $_POST['prodi'];
$fakultas = $_POST['fakultas'];
$angkatan = $_POST['angkatan'];

// Masukkan ke database
$query = "INSERT INTO dim_mahasiswa (nama, prodi, fakultas, angkatan) VALUES ('$nama', '$prodi', '$fakultas', '$angkatan')";

if(mysqli_query($koneksi, $query)) {
    // Kalau sukses, balik lagi ke halaman data mahasiswa
    echo "<script>alert('Data BERHASIL ditambahkan!'); document.location.href='data mahasiswa.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>