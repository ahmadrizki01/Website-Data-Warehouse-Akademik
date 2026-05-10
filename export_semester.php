<?php
include 'koneksi.php';

// Nama file yang akan didownload
$filename = "Data_Semester_".date('Ymd').".xls";

// Setting header agar didownload sebagai file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data dari database
$sql = "SELECT * FROM dim_semester";
$data = mysqli_query($koneksi, $sql);
?>

<table border="1">
  <thead>
    <tr>
      <th>ID Semester</th>
      <th>Semester</th>
      <th>Tahun Ajaran</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($row = mysqli_fetch_array($data)){
    ?>
    <tr>
      <td><?php echo $row['id_semester']; ?></td>
      <td><?php echo $row['semester']; ?></td>
      <td><?php echo $row['tahun_ajaran']; ?></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>