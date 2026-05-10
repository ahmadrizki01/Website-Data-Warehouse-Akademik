<?php
// Panggil koneksi database
include 'koneksi.php';

// Tangkap SEMUA data dari form (TERMASUK NIM)
$id_mahasiswa = $_POST['id_mahasiswa'];
$nama = $_POST['nama'];
$prodi = $_POST['prodi'];
$fakultas = $_POST['fakultas'];
$angkatan = $_POST['angkatan'];

// Masukkan data ke database (URUTANNYA SUDAH BENAR SEKARANG)
$query = "INSERT INTO dim_mahasiswa (id_mahasiswa, nama, prodi, fakultas, angkatan) 
          VALUES ('$id_mahasiswa', '$nama', '$prodi', '$fakultas', '$angkatan')";

if(mysqli_query($koneksi, $query)) {
    // Kalau berhasil, balik lagi ke halaman data mahasiswa
    echo "<script>alert('Data BERHASIL disimpan!'); document.location.href='data mahasiswa.php';</script>";
} else {
    // Kalau error
    echo "Gagal: " . mysqli_error($koneksi);
}
?>