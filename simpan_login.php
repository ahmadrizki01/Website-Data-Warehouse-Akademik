<?php
// Panggil koneksi database
include 'koneksi.php';

// Tangkap data dari form
$email = $_POST['email'];
$pass  = $_POST['password'];

// Masukkan data ke tabel login
$query = "INSERT INTO login (email, password) VALUES ('$email', '$pass')";

if(mysqli_query($koneksi, $query)) {
    echo "
    <script>
    alert('Data BERHASIL masuk ke Database!');
    document.location.href='dashboard.php'; // Setelah sukses, lari ke Dashboard
    </script>
    ";
} else {
    echo "GAGAL: " . mysqli_error($koneksi);
}
?>