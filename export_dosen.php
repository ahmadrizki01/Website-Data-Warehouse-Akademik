<?php
include 'koneksi.php';

// Nama file yang akan didownload
$filename = "Data_Dosen_".date('Ymd').".xls";

// Setting header agar didownload sebagai file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari database
$sql = "SELECT * FROM dim_dosen";
$data = mysqli_query($koneksi, $sql);
?>

<table border="1">
  <thead>
    <tr>
      <th>ID Dosen</th>
      <th>Nama Dosen</th>
      <th>Jabatan</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($row = mysqli_fetch_array($data)){
    ?>
    <tr>
      <td><?php echo $row['id_dosen']; ?></td>
      <td><?php echo $row['nama_dosen']; ?></td>
      <td><?php echo $row['jabatan']; ?></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>