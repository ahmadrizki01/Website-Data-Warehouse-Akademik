<?php
$conn = mysqli_connect("localhost", "root", "", "dw_akademik");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$email = $_POST['email'];
$password = $_POST['password'];

// insert ke database
$query = "INSERT INTO login (email, password) VALUES ('$email', '$password')";

if (mysqli_query($conn, $query)) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>