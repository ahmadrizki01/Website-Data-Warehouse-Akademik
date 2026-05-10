<?php
include 'koneksi.php';

// Nama file yang akan didownload
$filename = "Data_Matakuliah_".date('Ymd').".xls";

// Setting header agar didownload sebagai file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari database
$sql = "SELECT * FROM dim_matakuliah";
$data = mysqli_query($koneksi, $sql);
?>

<table border="1">
  <thead>
    <tr>
      <th>ID Matakuliah</th>
      <th>Nama Matakuliah</th>
      <th>SKS</th>
      <th>Semester</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($row = mysqli_fetch_array($data)){
    ?>
    <tr>
      <td><?php echo $row['id_Matakuliah']; ?></td>
      <td><?php echo $row['nama_Matakuliah']; ?></td>
      <td><?php echo $row['sks']; ?></td>
      <td><?php echo $row['semester']; ?></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>