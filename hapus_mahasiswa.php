<?php
include 'koneksi.php';

// Ambil ID dari alamat
$id = $_GET['id'];

// Cek apakah data mahasiswa masih digunakan di tabel KRS
$cek_penggunaan = mysqli_query($koneksi, "SELECT * FROM fact_krs WHERE id_mahasiswa = '$id'");
if(mysqli_num_rows($cek_penggunaan) > 0){
    echo "<script>
        alert('Data ini tidak dapat dihapus! Karena masih terhubung dengan data KRS. Hapus data KRS terkait terlebih dahulu.');
        window.location='data mahasiswa.php';
    </script>";
    exit;
}

// Jika tidak dipakai, hapus data
$hapus = mysqli_query($koneksi, "DELETE FROM dim_mahasiswa WHERE id_mahasiswa = '$id'");

if($hapus){
    echo "<script>alert('Data mahasiswa berhasil dihapus!'); window.location='data mahasiswa.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data! Terjadi kesalahan: ".mysqli_error($koneksi)."'); window.location='data mahasiswa.php';</script>";
}
?>