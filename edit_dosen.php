<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM dim_dosen WHERE id_dosen='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Data Dosen</title>
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
            <h3 class="card-title">Edit Data Dosen</h3>
            <form method="post" action="update_dosen.php">
              <div class="form-group">
                <label>ID Dosen</label>
                <input type="hidden" name="id_dosen" value="<?php echo $d['id_dosen']; ?>">
                <input type="text" class="form-control" value="<?php echo $d['id_dosen']; ?>" disabled>
              </div>
              <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" name="nama_dosen" class="form-control" value="<?php echo $d['nama_dosen']; ?>" required>
              </div>
              <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?php echo $d['jabatan']; ?>" required>
              </div>
              <button type="submit" class="btn btn-gradient-primary">Update</button>
              <a href="data dosen.php" class="btn btn-light">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>