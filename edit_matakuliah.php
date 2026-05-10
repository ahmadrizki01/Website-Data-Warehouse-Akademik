<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM dim_matakuliah WHERE id_Matakuliah='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Data Matakuliah</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Edit Data Matakuliah</h3>
            <form method="post" action="update_matakuliah.php">
              <div class="form-group">
                <label>ID Matakuliah</label>
                <input type="hidden" name="id_Matakuliah" value="<?php echo $d['id_Matakuliah']; ?>">
                <input type="text" class="form-control" value="<?php echo $d['id_Matakuliah']; ?>" disabled>
              </div>
              <div class="form-group">
                <label>Nama Matakuliah</label>
                <input type="text" name="nama_Matakuliah" class="form-control" value="<?php echo $d['nama_Matakuliah']; ?>" required>
              </div>
              <div class="form-group">
                <label>SKS</label>
                <input type="number" name="sks" class="form-control" value="<?php echo $d['sks']; ?>" required>
              </div>
              <div class="form-group">
                <label>Semester</label>
                <input type="number" name="semester" class="form-control" value="<?php echo $d['semester']; ?>" required>
              </div>
              <button type="submit" class="btn btn-gradient-primary">Update</button>
              <a href="data matakuliah.php" class="btn btn-light">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>