<?php
include 'koneksi.php';

// Ambil ID semester dari alamat tautan
$id = $_GET['id'];

// Periksa apakah data semester masih digunakan atau terhubung di dalam tabel KRS
$cek_keterkaitan = mysqli_query($koneksi, "SELECT * FROM fact_krs WHERE id_semester = '$id'");

// Jika masih ada hubungan data
if(mysqli_num_rows($cek_keterkaitan) > 0){
    echo "<script>
        alert('⚠️ Data ini TIDAK DAPAT dihapus!\\n\\nKarena data Semester ini masih terhubung dan dipakai dalam Data KRS.\\nSilakan hapus seluruh Data KRS yang berhubungan terlebih dahulu.');
        window.location='data semester.php';
    </script>";
    exit;
}

// Jika tidak ada hubungan, lanjutkan proses penghapusan
$proses_hapus = mysqli_query($koneksi, "DELETE FROM dim_semester WHERE id_semester = '$id'");

// Pemberitahuan hasil proses
if($proses_hapus){
    echo "<script>
        alert('✅ Data Semester berhasil dihapus dari sistem!');
        window.location='data semester.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Gagal menghapus data!\\n\\nTerjadi kesalahan: ".mysqli_error($koneksi)."');
        window.location='data semester.php';
    </script>";
}
?>