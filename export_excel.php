<?php
// Koneksi Database
include 'koneksi.php';

// Nama file yang akan didownload
$filename = "Data_Mahasiswa_".date('Ymd').".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Export Excel</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Program Studi</th>
                <th>Fakultas</th>
                <th>Angkatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa");
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['id_mahasiswa']; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['prodi']; ?></td>
                <td><?php echo $d['fakultas']; ?></td>
                <td><?php echo $d['angkatan']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>