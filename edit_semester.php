<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM dim_semester WHERE id_semester='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Data Semester</title>
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
            <h3 class="card-title">Edit Data Semester</h3>
            <form method="post" action="update_semester.php">
              <div class="form-group">
                <label>ID Semester</label>
                <input type="hidden" name="id_semester" value="<?php echo $d['id_semester']; ?>">
                <input type="text" class="form-control" value="<?php echo $d['id_semester']; ?>" disabled>
              </div>
              <div class="form-group">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                  <option value="Ganjil" <?php if($d['semester']=='Ganjil') echo 'selected'; ?>>Ganjil</option>
                  <option value="Genap" <?php if($d['semester']=='Genap') echo 'selected'; ?>>Genap</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" class="form-control" value="<?php echo $d['tahun_ajaran']; ?>" required>
              </div>
              <button type="submit" class="btn btn-gradient-primary">Update</button>
              <a href="data semester.php" class="btn btn-light">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>