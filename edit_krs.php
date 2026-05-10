<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data KRS yang mau diedit
$data = mysqli_query($koneksi, "
    SELECT 
        fk.*,
        m.nama AS nama_mahasiswa,
        mk.nama_Matakuliah,
        dsn.nama_dosen
    FROM fact_krs fk
    JOIN dim_mahasiswa m ON fk.id_mahasiswa = m.id_mahasiswa
    JOIN dim_matakuliah mk ON fk.id_Matakuliah = mk.id_Matakuliah
    JOIN dim_dosen dsn ON fk.id_dosen = dsn.id_dosen
    WHERE fk.id_krs = '$id'
");
$d = mysqli_fetch_array($data);

// Ambil data untuk dropdown
$mahasiswa = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa ORDER BY nama ASC");
$matakuliah = mysqli_query($koneksi, "SELECT * FROM dim_matakuliah ORDER BY nama_Matakuliah ASC");
$dosen = mysqli_query($koneksi, "SELECT * FROM dim_dosen ORDER BY nama_dosen ASC");
$waktu = mysqli_query($koneksi, "SELECT * FROM dim_waktu ORDER BY tahun DESC, bulan DESC");
$semester = mysqli_query($koneksi, "SELECT * FROM dim_semester ORDER BY tahun_ajaran DESC");

// Proses Update Data
if(isset($_POST['update'])){
    $id_krs         = $_POST['id_krs'];
    $id_mahasiswa   = $_POST['id_mahasiswa'];
    $id_Matakuliah  = $_POST['id_Matakuliah'];
    $id_dosen       = $_POST['id_dosen'];
    $id_Waktu       = $_POST['id_Waktu'];
    $id_semester    = $_POST['id_semester'];
    $sks            = $_POST['sks'];

    $update = mysqli_query($koneksi, "UPDATE fact_krs SET 
        id_mahasiswa = '$id_mahasiswa',
        id_Matakuliah = '$id_Matakuliah',
        id_dosen = '$id_dosen',
        id_Waktu = '$id_Waktu',
        id_semester = '$id_semester',
        sks = '$sks'
        WHERE id_krs = '$id_krs'");

    if($update){
        echo "<script>alert('Data berhasil diupdate!'); window.location='lihat data krs.php';</script>";
    }else{
        echo "<script>alert('Gagal update data!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Data KRS</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Edit Data KRS</h3>
            <form method="post" action="">
              <input type="hidden" name="id_krs" value="<?php echo $d['id_krs']; ?>">
              
              <div class="form-group">
                <label>Mahasiswa</label>
                <select name="id_mahasiswa" class="form-control" required>
                  <option value="">-- Pilih Mahasiswa --</option>
                  <?php foreach($mahasiswa as $m){ ?>
                  <option value="<?php echo $m['id_mahasiswa']; ?>" <?php if($d['id_mahasiswa'] == $m['id_mahasiswa']) echo 'selected'; ?>>
                    <?php echo $m['id_mahasiswa']; ?> - <?php echo $m['nama']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="id_Matakuliah" class="form-control" required>
                  <option value="">-- Pilih Mata Kuliah --</option>
                  <?php foreach($matakuliah as $mk){ ?>
                  <option value="<?php echo $mk['id_Matakuliah']; ?>" <?php if($d['id_Matakuliah'] == $mk['id_Matakuliah']) echo 'selected'; ?>>
                    <?php echo $mk['id_Matakuliah']; ?> - <?php echo $mk['nama_Matakuliah']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Dosen</label>
                <select name="id_dosen" class="form-control" required>
                  <option value="">-- Pilih Dosen --</option>
                  <?php foreach($dosen as $dsn){ ?>
                  <option value="<?php echo $dsn['id_dosen']; ?>" <?php if($d['id_dosen'] == $dsn['id_dosen']) echo 'selected'; ?>>
                    <?php echo $dsn['id_dosen']; ?> - <?php echo $dsn['nama_dosen']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Waktu</label>
                    <select name="id_Waktu" class="form-control" required>
                      <?php foreach($waktu as $w){ ?>
                      <option value="<?php echo $w['id_Waktu']; ?>" <?php if($d['id_Waktu'] == $w['id_Waktu']) echo 'selected'; ?>>
                        <?php echo $w['tahun']; ?> - <?php echo $w['bulan']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Semester</label>
                    <select name="id_semester" class="form-control" required>
                      <?php foreach($semester as $s){ ?>
                      <option value="<?php echo $s['id_semester']; ?>" <?php if($d['id_semester'] == $s['id_semester']) echo 'selected'; ?>>
                        <?php echo $s['semester']; ?> - <?php echo $s['tahun_ajaran']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>SKS</label>
                    <input type="number" name="sks" class="form-control" value="<?php echo $d['sks']; ?>" required>
                  </div>
                </div>
              </div>

              <button type="submit" name="update" class="btn btn-gradient-primary">Update</button>
              <a href="lihat data krs.php" class="btn btn-light">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html><?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data KRS yang mau diedit
$data = mysqli_query($koneksi, "
    SELECT 
        fk.*,
        m.nama AS nama_mahasiswa,
        mk.nama_Matakuliah,
        dsn.nama_dosen
    FROM fact_krs fk
    JOIN dim_mahasiswa m ON fk.id_mahasiswa = m.id_mahasiswa
    JOIN dim_matakuliah mk ON fk.id_Matakuliah = mk.id_Matakuliah
    JOIN dim_dosen dsn ON fk.id_dosen = dsn.id_dosen
    WHERE fk.id_krs = '$id'
");
$d = mysqli_fetch_array($data);

// Ambil data untuk dropdown
$mahasiswa = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa ORDER BY nama ASC");
$matakuliah = mysqli_query($koneksi, "SELECT * FROM dim_matakuliah ORDER BY nama_Matakuliah ASC");
$dosen = mysqli_query($koneksi, "SELECT * FROM dim_dosen ORDER BY nama_dosen ASC");
$waktu = mysqli_query($koneksi, "SELECT * FROM dim_waktu ORDER BY tahun DESC, bulan DESC");
$semester = mysqli_query($koneksi, "SELECT * FROM dim_semester ORDER BY tahun_ajaran DESC");

// Proses Update Data
if(isset($_POST['update'])){
    $id_krs         = $_POST['id_krs'];
    $id_mahasiswa   = $_POST['id_mahasiswa'];
    $id_Matakuliah  = $_POST['id_Matakuliah'];
    $id_dosen       = $_POST['id_dosen'];
    $id_Waktu       = $_POST['id_Waktu'];
    $id_semester    = $_POST['id_semester'];
    $sks            = $_POST['sks'];

    $update = mysqli_query($koneksi, "UPDATE fact_krs SET 
        id_mahasiswa = '$id_mahasiswa',
        id_Matakuliah = '$id_Matakuliah',
        id_dosen = '$id_dosen',
        id_Waktu = '$id_Waktu',
        id_semester = '$id_semester',
        sks = '$sks'
        WHERE id_krs = '$id_krs'");

    if($update){
        echo "<script>alert('Data berhasil diupdate!'); window.location='lihat data krs.php';</script>";
    }else{
        echo "<script>alert('Gagal update data!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Data KRS</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Edit Data KRS</h3>
            <form method="post" action="">
              <input type="hidden" name="id_krs" value="<?php echo $d['id_krs']; ?>">
              
              <div class="form-group">
                <label>Mahasiswa</label>
                <select name="id_mahasiswa" class="form-control" required>
                  <option value="">-- Pilih Mahasiswa --</option>
                  <?php foreach($mahasiswa as $m){ ?>
                  <option value="<?php echo $m['id_mahasiswa']; ?>" <?php if($d['id_mahasiswa'] == $m['id_mahasiswa']) echo 'selected'; ?>>
                    <?php echo $m['id_mahasiswa']; ?> - <?php echo $m['nama']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="id_Matakuliah" class="form-control" required>
                  <option value="">-- Pilih Mata Kuliah --</option>
                  <?php foreach($matakuliah as $mk){ ?>
                  <option value="<?php echo $mk['id_Matakuliah']; ?>" <?php if($d['id_Matakuliah'] == $mk['id_Matakuliah']) echo 'selected'; ?>>
                    <?php echo $mk['id_Matakuliah']; ?> - <?php echo $mk['nama_Matakuliah']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Dosen</label>
                <select name="id_dosen" class="form-control" required>
                  <option value="">-- Pilih Dosen --</option>
                  <?php foreach($dosen as $dsn){ ?>
                  <option value="<?php echo $dsn['id_dosen']; ?>" <?php if($d['id_dosen'] == $dsn['id_dosen']) echo 'selected'; ?>>
                    <?php echo $dsn['id_dosen']; ?> - <?php echo $dsn['nama_dosen']; ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Waktu</label>
                    <select name="id_Waktu" class="form-control" required>
                      <?php foreach($waktu as $w){ ?>
                      <option value="<?php echo $w['id_Waktu']; ?>" <?php if($d['id_Waktu'] == $w['id_Waktu']) echo 'selected'; ?>>
                        <?php echo $w['tahun']; ?> - <?php echo $w['bulan']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Semester</label>
                    <select name="id_semester" class="form-control" required>
                      <?php foreach($semester as $s){ ?>
                      <option value="<?php echo $s['id_semester']; ?>" <?php if($d['id_semester'] == $s['id_semester']) echo 'selected'; ?>>
                        <?php echo $s['semester']; ?> - <?php echo $s['tahun_ajaran']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>SKS</label>
                    <input type="number" name="sks" class="form-control" value="<?php echo $d['sks']; ?>" required>
                  </div>
                </div>
              </div>

              <button type="submit" name="update" class="btn btn-gradient-primary">Update</button>
              <a href="lihat data krs.php" class="btn btn-light">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>