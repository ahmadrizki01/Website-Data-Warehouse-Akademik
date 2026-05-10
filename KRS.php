<?php
include 'koneksi.php';

// Ambil data untuk pilihan di formulir — SESUAI STRUKTUR ASLI
$mahasiswa  = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa ORDER BY id_mahasiswa ASC");
$matakuliah = mysqli_query($koneksi, "SELECT * FROM dim_matakuliah ORDER BY id_Matakuliah ASC");
$dosen      = mysqli_query($koneksi, "SELECT * FROM dim_dosen ORDER BY id_dosen ASC");
$waktu      = mysqli_query($koneksi, "SELECT * FROM dim_waktu ORDER BY id_Waktu ASC"); // kolom: id_Waktu, tahun, bulan
$semester   = mysqli_query($koneksi, "SELECT * FROM dim_semester ORDER BY id_semester DESC");

// Proses simpan data ke tabel fact_krs
if(isset($_POST['simpan'])){
    $id_mahasiswa   = $_POST['id_mahasiswa'];
    $id_matakuliah  = $_POST['id_Matakuliah'];
    $id_dosen       = $_POST['id_dosen'];
    $id_waktu       = $_POST['id_Waktu'];
    $id_semester    = $_POST['id_semester'];
    $sks            = $_POST['sks'];

    // Cek agar data tidak ganda
    $cek = mysqli_query($koneksi, "SELECT * FROM fact_krs 
                                    WHERE id_mahasiswa='$id_mahasiswa' 
                                    AND id_Matakuliah='$id_matakuliah' 
                                    AND id_semester='$id_semester'");
    
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Data KRS untuk mahasiswa, mata kuliah, dan semester ini sudah ada! Tidak boleh ada yang sama.');</script>";
    } else {
        $simpan = mysqli_query($koneksi, "INSERT INTO fact_krs (id_mahasiswa, id_Matakuliah, id_dosen, id_Waktu, id_semester, sks) 
                                           VALUES ('$id_mahasiswa', '$id_matakuliah', '$id_dosen', '$id_waktu', '$id_semester', '$sks')");
        if($simpan){
            echo "<script>alert('Data KRS berhasil disimpan!'); window.location='lihat data krs.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data! Silakan periksa kembali.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="index.html"><h3>Input Data KRS</h3></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="f1.jpg" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">Admin Akademik</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-cached me-2 text-success"></i> Catatan Aktivitas </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Keluar </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
          
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-power"></i>
              </a>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-format-line-spacing"></i>
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="f1.jpg" alt="profil" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Admin Akademik</span>
          <span class="text-secondary text-small">Gudang Data</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

     <li class="nav-item">
      <a class="nav-link" href="index.html">
        <span class="menu-title">Dasbor</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <!-- MENU DATA INDUK -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#dataMaster" aria-expanded="false" aria-controls="dataMaster">
        <span class="menu-title">Data Induk</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-database menu-icon"></i>
      </a>
      <div class="collapse" id="dataMaster">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="data mahasiswa.html"> Data Mahasiswa </a></li>
          <li class="nav-item"> <a class="nav-link" href="data dosen.html"> Data Dosen </a></li>
          <li class="nav-item"> <a class="nav-link" href="data matakuliah.html"> Data Mata Kuliah </a></li>
          <li class="nav-item"> <a class="nav-link" href="data semester.html"> Data Semester </a></li>
        </ul>
      </div>
    </li>

    <!-- MENU DATA KRS -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#dataKrs" aria-expanded="true" aria-controls="dataKrs">
        <span class="menu-title">Data KRS</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-clipboard-text menu-icon"></i>
      </a>
      <div class="collapse show" id="dataKrs">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link active" href="input_krs.php"> Masukkan KRS </a></li>
          <li class="nav-item"> <a class="nav-link" href="lihat data krs.php"> Lihat Data KRS </a></li>
        </ul>
      </div>
    </li>

    <!-- MENU PENYARINGAN DATA -->
    <li class="nav-item">
      <a class="nav-link" href="filter Data.html">
        <span class="menu-title">Penyaringan Data</span>
        <i class="mdi mdi-filter-outline menu-icon"></i>
      </a>
    </li>

    <!-- MENU EKSPOR LAPORAN -->
    <li class="nav-item">
      <a class="nav-link" href="export Laporan.html">
        <span class="menu-title">Ekspor Laporan</span>
        <i class="mdi mdi-file-excel menu-icon"></i>
      </a>
    </li>

    <!-- MENU KELUAR -->
    <li class="nav-item">
      <a class="nav-link" href="login.html">
        <span class="menu-title">Keluar</span>
        <i class="mdi mdi-logout menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-clipboard-text"></i>
                </span> Form Masukkan Data KRS
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Data KRS</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Masukkan Data KRS</li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Lengkapi Informasi Berikut</h4>
                    <form method="POST" action="">
                      <!-- PILIHAN MAHASISWA -->
                      <div class="form-group">
                        <label>Pilih Mahasiswa</label>
                        <select name="id_mahasiswa" class="form-control form-control-lg" required>
                          <option value="">-- Pilih Mahasiswa --</option>
                          <?php while($mhs = mysqli_fetch_array($mahasiswa)){ ?>
                            <option value="<?= $mhs['id_mahasiswa'] ?>">
                              <?= $mhs['id_mahasiswa'] ?> | <?= $mhs['nama'] ?> | <?= $mhs['prodi'] ?> | <?= $mhs['fakultas'] ?> | Angkatan: <?= $mhs['angkatan'] ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- PILIHAN MATA KULIAH -->
                      <div class="form-group">
                        <label>Pilih Mata Kuliah</label>
                        <select name="id_Matakuliah" class="form-control form-control-lg" required>
                          <option value="">-- Pilih Mata Kuliah --</option>
                          <?php while($mk = mysqli_fetch_array($matakuliah)){ ?>
                            <option value="<?= $mk['id_Matakuliah'] ?>"><?= $mk['id_Matakuliah'] ?> | <?= $mk['nama_Matakuliah'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- PILIHAN DOSEN -->
                      <div class="form-group">
                        <label>Pilih Dosen Pengampu</label>
                        <select name="id_dosen" class="form-control form-control-lg" required>
                          <option value="">-- Pilih Dosen --</option>
                          <?php while($dsn = mysqli_fetch_array($dosen)){ ?>
                            <option value="<?= $dsn['id_dosen'] ?>"><?= $dsn['id_dosen'] ?> | <?= $dsn['nama_dosen'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- PILIHAN WAKTU (SESUAI KOLOM: id_Waktu, TAHUN, BULAN) -->
                      <div class="form-group">
                        <label>Pilih Waktu</label>
                        <select name="id_Waktu" class="form-control form-control-lg" required>
                          <option value="">-- Pilih Tahun dan Bulan --</option>
                          <?php while($wkt = mysqli_fetch_array($waktu)){ ?>
                            <option value="<?= $wkt['id_Waktu'] ?>">
                              <?= $wkt['id_Waktu'] ?> | Tahun: <?= $wkt['tahun'] ?> | Bulan: <?= $wkt['bulan'] ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- PILIHAN SEMESTER -->
                      <div class="form-group">
                        <label>Pilih Semester & Tahun Ajaran</label>
                        <select name="id_semester" class="form-control form-control-lg" required>
                          <option value="">-- Pilih Semester --</option>
                          <?php while($smt = mysqli_fetch_array($semester)){ ?>
                            <option value="<?= $smt['id_semester'] ?>"><?= $smt['semester'] ?> | <?= $smt['tahun_ajaran'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- JUMLAH SKS -->
                      <div class="form-group">
                        <label>Jumlah SKS</label>
                        <input type="number" name="sks" class="form-control form-control-lg" placeholder="Misal: 2, 3, 4" min="1" max="6" required>
                      </div>

                      <br>
                      <button type="submit" name="simpan" class="btn btn-gradient-primary me-2">Simpan Data</button>
                      <a href="lihat data krs.php" class="btn btn-light">Batal</a>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved. Distributed by <a href="http://themewagon.com" target="_blank">ThemeWagon</a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>





