<?php
include 'koneksi.php';

// Ambil ID mahasiswa dari alamat
$id = $_GET['id'];

// Ambil data mahasiswa yang akan diubah
$ambil_data = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa WHERE id_mahasiswa = '$id'");
$data = mysqli_fetch_array($ambil_data);

// Proses ubah data jika tombol disimpan diklik
if(isset($_POST['ubah'])){
    $nama       = $_POST['nama'];
    $prodi      = $_POST['prodi'];
    $fakultas   = $_POST['fakultas'];
    $angkatan   = $_POST['angkatan'];

    $perbarui = mysqli_query($koneksi, "UPDATE dim_mahasiswa SET 
                nama = '$nama',
                prodi = '$prodi',
                fakultas = '$fakultas',
                angkatan = '$angkatan'
                WHERE id_mahasiswa = '$id'");

    if($perbarui){
        echo "<script>alert('Data mahasiswa berhasil diubah!'); window.location='data mahasiswa.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data! ".mysqli_error($koneksi)."'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
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
          <a class="navbar-brand brand-logo" href="index.html"><h3>Data KRS</h3></a>
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
                <input type="text" class="form-control bg-transparent border-0" placeholder="Cari Data">
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
                <a class="dropdown-item" href="login.html">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Keluar </a>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
          
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="login.html">
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
      <a class="nav-link" data-bs-toggle="collapse" href="#dataMaster" aria-expanded="true" aria-controls="dataMaster">
        <span class="menu-title">Data Induk</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-database menu-icon"></i>
      </a>
      <div class="collapse show" id="dataMaster">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link active" href="data mahasiswa.html"> Data Mahasiswa </a></li>
          <li class="nav-item"> <a class="nav-link" href="data dosen.html"> Data Dosen </a></li>
          <li class="nav-item"> <a class="nav-link" href="data matakuliah.html"> Data Mata Kuliah </a></li>
          <li class="nav-item"> <a class="nav-link" href="data semester.html"> Data Semester </a></li>
        </ul>
      </div>
    </li>

    <!-- MENU DATA KRS -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#dataKrs" aria-expanded="false" aria-controls="dataKrs">
        <span class="menu-title">Data KRS</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-clipboard-text menu-icon"></i>
      </a>
      <div class="collapse" id="dataKrs">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="input_krs.php"> Masukkan KRS </a></li>
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
                  <i class="mdi mdi-account-edit"></i>
                </span> Ubah Data Mahasiswa
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Data Induk</a></li>
                  <li class="breadcrumb-item"><a href="data mahasiswa.html">Data Mahasiswa</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Ubah Data</li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h4 class="card-title mb-0">Formulir Perubahan Data</h4>
                      <a href="data mahasiswa.html" class="btn btn-light btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i> Kembali
                      </a>
                    </div>

                    <form method="POST" action="">
                      <div class="form-group">
                        <label>Kode Mahasiswa</label>
                        <input type="text" class="form-control" value="<?= $data['id_mahasiswa'] ?>" readonly style="background-color: #f3f3f3;">
                        <small class="text-muted">Kode tidak dapat diubah</small>
                      </div>

                      <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                      </div>

                      <div class="form-group">
                        <label>Program Studi <span class="text-danger">*</span></label>
                        <select name="prodi" class="form-control" required>
                          <option value="Informatika" <?= ($data['prodi']=='Informatika')?'selected':'' ?>>Informatika</option>
                          <option value="Sistem Informasi" <?= ($data['prodi']=='Sistem Informasi')?'selected':'' ?>>Sistem Informasi</option>
                          <option value="Teknik Komputer" <?= ($data['prodi']=='Teknik Komputer')?'selected':'' ?>>Teknik Komputer</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Fakultas <span class="text-danger">*</span></label>
                        <input type="text" name="fakultas" class="form-control" value="<?= $data['fakultas'] ?>" readonly style="background-color: #f3f3f3;">
                        <small class="text-muted">Fakultas tetap Ilmu Komputer</small>
                      </div>

                      <div class="form-group">
                        <label>Tahun Angkatan <span class="text-danger">*</span></label>
                        <input type="number" name="angkatan" class="form-control" min="2015" max="2026" value="<?= $data['angkatan'] ?>" required>
                      </div>

                      <hr>

                      <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-light btn-sm me-2">
                          <i class="mdi mdi-reload me-1"></i> Atur Ulang
                        </button>
                        <button type="submit" name="ubah" class="btn btn-gradient-primary btn-sm">
                          <i class="mdi mdi-content-save me-1"></i> Simpan Perubahan
                        </button>
                      </div>
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
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Hak Cipta © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. Semua hak dilindungi undang-undang. Sebaran oleh <a href="http://themewagon.com" target="_blank">ThemeWagon</a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Dibuat dengan <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <!-- endinject -->
  </body>
</html>