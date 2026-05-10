<?php
include 'koneksi.php';

// Inisialisasi variabel filter
$filter_prodi       = isset($_GET['prodi']) ? $_GET['prodi'] : '';
$filter_tahun       = isset($_GET['tahun_angkatan']) ? $_GET['tahun_angkatan'] : '';
$filter_semester    = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_tahun_ajar  = isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '';

// Membuat kueri dasar
$sql = "SELECT 
            fk.id_krs,
            m.id_mahasiswa,
            m.nama AS nama_mahasiswa,
            m.prodi,
            m.angkatan,
            mk.nama_matakuliah,
            mk.sks,
            dsn.nama_dosen,
            smt.semester,
            smt.tahun_ajaran
        FROM fact_krs fk
        JOIN dim_mahasiswa m ON fk.id_mahasiswa = m.id_mahasiswa
        JOIN dim_matakuliah mk ON fk.id_matakuliah = mk.id_matakuliah
        JOIN dim_dosen dsn ON fk.id_dosen = dsn.id_dosen
        JOIN dim_semester smt ON fk.id_semester = smt.id_semester
        WHERE 1=1 ";

// Menambahkan kondisi filter jika ada input
if (!empty($filter_prodi)) {
    $sql .= " AND m.prodi = '$filter_prodi' ";
}
if (!empty($filter_tahun)) {
    $sql .= " AND m.angkatan = '$filter_tahun' ";
}
if (!empty($filter_semester)) {
    $sql .= " AND smt.semester = '$filter_semester' ";
}
if (!empty($filter_tahun_ajar)) {
    $sql .= " AND smt.tahun_ajaran = '$filter_tahun_ajar' ";
}

$sql .= " ORDER BY fk.id_krs DESC";
$query = mysqli_query($koneksi, $sql);

// Ambil data untuk pilihan opsi filter
$list_prodi      = mysqli_query($koneksi, "SELECT DISTINCT prodi FROM dim_mahasiswa");
$list_angkatan   = mysqli_query($koneksi, "SELECT DISTINCT angkatan FROM dim_mahasiswa ORDER BY angkatan DESC");
$list_semester   = mysqli_query($koneksi, "SELECT DISTINCT semester FROM dim_semester");
$list_thn_ajar   = mysqli_query($koneksi, "SELECT DISTINCT tahun_ajaran FROM dim_semester ORDER BY tahun_ajaran DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Filter Data - Sistem Informasi Akademik</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
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
          <a class="navbar-brand brand-logo" href="index.html"><h3>Filter Data</h3></a>
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
                <input type="text" class="form-control bg-transparent border-0" placeholder="Cari Data...">
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
                  <i class="mdi mdi-cached me-2 text-success"></i> Riwayat Aktivitas </a>
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
          <img src="f1.jpg" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Admin Akademik</span>
          <span class="text-secondary text-small">Data Warehouse</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <!-- MENU DASHBOARD -->
         <!-- MENU DASHBOARD -->
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <!-- MENU DATA MASTER -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#dataMaster" aria-expanded="false" aria-controls="dataMaster">
        <span class="menu-title">Data Master</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-database menu-icon"></i>
      </a>
      <div class="collapse" id="dataMaster">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="data mahasiswa.php"> Data Mahasiswa </a></li>
          <li class="nav-item"> <a class="nav-link" href="data dosen.php"> Data Dosen </a></li>
          <li class="nav-item"> <a class="nav-link" href="data matakuliah.php"> Data Mata Kuliah </a></li>
          <li class="nav-item"> <a class="nav-link" href="data semester.php"> Data Semester </a></li>
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
          <li class="nav-item"> <a class="nav-link" href="lihat data krs.php"> Lihat Data KRS </a></li>
        </ul>
      </div>
    </li>

    <!-- MENU FILTER DATA -->
    <li class="nav-item">
      <a class="nav-link" href="filter Data.php">
        <span class="menu-title">Filter Data</span>
        <i class="mdi mdi-filter-outline menu-icon"></i>
      </a>
    </li>

    <!-- MENU EXPORT LAPORAN -->
    <li class="nav-item">
      <a class="nav-link" href="export Laporan.php">
        <span class="menu-title">Export Laporan</span>
        <i class="mdi mdi-file-excel menu-icon"></i>
      </a>
    </li>

    <!-- MENU LOGOUT -->
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <span class="menu-title">Logout</span>
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
                  <i class="mdi mdi-filter-outline"></i>
                </span> Filter Data KRS
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Filter Data</li>
                </ul>
              </nav>
            </div>


<!-- FORM FILTER -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Kriteria Pencarian Data</h4>
                            <form method="GET" action="">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label fw-semibold">Program Studi</label>
                                        <select name="prodi" class="form-control form-control-lg">
                                            <option value="">-- Semua Prodi --</option>
                                            <?php while ($p = mysqli_fetch_array($list_prodi)) { ?>
                                            <option value="<?= $p['prodi'] ?>" <?= ($filter_prodi == $p['prodi']) ? 'selected' : '' ?>><?= $p['prodi'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <label class="form-label fw-semibold">Tahun Angkatan</label>
                                        <select name="tahun_angkatan" class="form-control form-control-lg">
                                            <option value="">-- Semua Tahun --</option>
                                            <?php while ($t = mysqli_fetch_array($list_angkatan)) { ?>
                                            <option value="<?= $t['angkatan'] ?>" <?= ($filter_tahun == $t['angkatan']) ? 'selected' : '' ?>><?= $t['angkatan'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <label class="form-label fw-semibold">Semester</label>
                                        <select name="semester" class="form-control form-control-lg">
                                            <option value="">-- Semua Semester --</option>
                                            <?php while ($s = mysqli_fetch_array($list_semester)) { ?>
                                            <option value="<?= $s['semester'] ?>" <?= ($filter_semester == $s['semester']) ? 'selected' : '' ?>><?= $s['semester'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label fw-semibold">Tahun Ajaran</label>
                                        <select name="tahun_ajaran" class="form-control form-control-lg">
                                            <option value="">-- Semua Tahun Ajaran --</option>
                                            <?php while ($ta = mysqli_fetch_array($list_thn_ajar)) { ?>
                                            <option value="<?= $ta['tahun_ajaran'] ?>" <?= ($filter_tahun_ajar == $ta['tahun_ajaran']) ? 'selected' : '' ?>><?= $ta['tahun_ajaran'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12 d-grid">
                                        <button type="submit" class="btn btn-gradient-primary btn-lg">
                                            <i class="mdi mdi-magnify me-1"></i> Tampilkan Data
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL HASIL DATA -->
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Hasil Data KRS</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped" id="tabel-data">
                        <thead class="table-primary">
                          <tr>
                            <th> No </th>
                            <th> NIM </th>
                            <th> Nama Mahasiswa </th>
                            <th> Prodi </th>
                            <th> Angkatan </th>
                            <th> Mata Kuliah </th>
                            <th> SKS </th>
                            <th> Dosen Pengampu </th>
                            <th> Semester </th>
                            <th> Tahun Ajaran </th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                          <tr>
                            <td> <?= $no++ ?> </td>
                            <td> <?= $data['id_mahasiswa'] ?> </td>
                            <td> <?= $data['nama_mahasiswa'] ?> </td>
                            <td> <?= $data['prodi'] ?> </td>
                            <td> <?= $data['angkatan'] ?> </td>
                            <td> <?= $data['nama_matakuliah'] ?> </td>
                            <td> <?= $data['sks'] ?> </td>
                            <td> <?= $data['nama_dosen'] ?> </td>
                            <td> <?= $data['semester'] ?> </td>
                            <td> <?= $data['tahun_ajaran'] ?> </td>
                          </tr>
                          <?php 
                            } 
                            if(mysqli_num_rows($query) == 0){
                          ?>
                          <tr>
                            <td colspan="10" class="text-center">Tidak ada data yang ditemukan sesuai kriteria pencarian</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2026 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. Hak Cipta Dilindungi Undang-Undang. Dikembangkan oleh <a href="http://themewagon.com" target="_blank">ThemeWagon</a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Dibuat dengan <i class="mdi mdi-heart text-danger"></i> oleh Tim Pengembang</span>
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
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "url": "assets/vendors/datatables.net/Indonesian.json"
                }
            });
        });
    </script>
    <!-- End custom js for this page -->
</body>
</html>
















