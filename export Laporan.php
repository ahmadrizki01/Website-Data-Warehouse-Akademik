<?php
include 'koneksi.php';

// Inisialisasi variabel untuk penyaringan
$filter_prodi       = isset($_GET['prodi']) ? $_GET['prodi'] : '';
$filter_tahun       = isset($_GET['tahun_angkatan']) ? $_GET['tahun_angkatan'] : '';
$filter_semester    = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_tahun_ajar  = isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '';

// Membuat kueri untuk mengambil data
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

// Menambahkan kondisi penyaringan jika ada
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

$sql .= " ORDER BY m.prodi ASC, m.nama ASC";
$query = mysqli_query($koneksi, $sql);

// Mengambil data untuk pilihan opsi penyaringan
$list_prodi      = mysqli_query($koneksi, "SELECT DISTINCT prodi FROM dim_mahasiswa ORDER BY prodi ASC");
$list_angkatan   = mysqli_query($koneksi, "SELECT DISTINCT angkatan FROM dim_mahasiswa ORDER BY angkatan DESC");
$list_semester   = mysqli_query($koneksi, "SELECT DISTINCT semester FROM dim_semester");
$list_thn_ajar   = mysqli_query($koneksi, "SELECT DISTINCT tahun_ajaran FROM dim_semester ORDER BY tahun_ajaran DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ekspor Laporan - Sistem Informasi Akademik</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="assets/vendors/datatables.net/buttons/buttons.bootstrap4.min.css">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .card {
                border: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-scroller">
      <!-- Bagian Atas -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="index.html"><h3>Ekspor Laporan</h3></a>
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
                  <img src="f1.jpg" alt="gambar profil">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">Admin Akademik</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-cached me-2 text-success"></i> Riwayat Aktivitas 
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="login.html">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Keluar 
                </a>
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
      <!-- Akhir Bagian Atas -->

      <div class="container-fluid page-body-wrapper">
        <!-- Bilah Samping -->
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

            <!-- Menu Dasbor -->
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
        <!-- Akhir Bilah Samping -->

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-file-excel"></i>
                </span> Ekspor & Cetak Laporan
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Ekspor Laporan</li>
                </ul>
              </nav>
            </div>

            <!-- Formulir Penyaringan -->
            <div class="row no-print">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Kriteria Data Laporan</h4>
                            <form method="GET" action="" class="row g-3 align-items-end">
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
                                        <i class="mdi mdi-magnify me-1"></i> Tampilkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Laporan & Tombol Tindakan -->
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                        <h4 class="card-title mb-0">Daftar Data KRS</h4>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-gradient-success btn-md" id="tombolExcel">
                                <i class="mdi mdi-file-excel me-1"></i> Unduh Excel
                            </button>
                            <button type="button" class="btn btn-gradient-dark btn-md ms-2" onclick="window.print()">
                                <i class="mdi mdi-printer me-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>

                    <!-- Kepala Laporan saat Dicetak -->
                    <div class="text-center mb-4 d-none d-print-block">
                     <h3>LAPORAN DATA KRS MAHASISWA</h3>
                        <h5>SISTEM INFORMASI PENGELOLAAN DATA AKADEMIK</h5>
                        <?php if(!empty($filter_prodi)){ ?>
                        <p>Program Studi: <strong><?= $filter_prodi ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($filter_tahun)){ ?>
                        <p>Tahun Angkatan: <strong><?= $filter_tahun ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($filter_semester)){ ?>
                        <p>Semester: <strong><?= $filter_semester ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($filter_tahun_ajar)){ ?>
                        <p>Tahun Ajaran: <strong><?= $filter_tahun_ajar ?></strong></p>
                        <?php } ?>
                        <hr style="border: 1px solid #333;">
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped" id="tabel-laporan">
                        <thead class="table-primary">
                          <tr>
                            <th> No </th>
                            <th> NIM </th>
                            <th> Nama Mahasiswa </th>
                            <th> Program Studi </th>
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
                            <td colspan="10" class="text-center">Tidak ada data yang ditemukan sesuai kriteria yang dipilih</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>

                    <!-- Bagian Tanda Tangan saat Dicetak -->
                    <div class="row mt-5 d-none d-print-block">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 text-center">
                            <p>Palembang, <?= date('d F Y') ?></p>
                            <p>Pengelola Data Akademik</p>
                            <br><br><br>
                            <p><strong>Admin Akademik</strong></p>
                        </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- Penutup Bagian Isi -->

          <!-- Bagian Kaki Halaman -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Hak Cipta © 2026 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. Dilindungi Undang-Undang. Dikembangkan oleh <a href="http://themewagon.com" target="_blank">ThemeWagon</a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Dibuat dengan <i class="mdi mdi-heart text-danger"></i> oleh Tim Pengembang Sistem</span>
            </div>
          </footer>
          <!-- Akhir Bagian Kaki Halaman -->
        </div>
        <!-- Penutup Bagian Utama -->
      </div>
      <!-- Penutup Bagian Isi Utama -->
    </div>
    <!-- Penutup Seluruh Halaman -->

    <!-- Berkas Pendukung JavaScript -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- Akhir Berkas Pendukung -->

    <!-- Berkas Tambahan untuk Halaman Ini -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="assets/vendors/datatables.net/buttons/dataTables.buttons.min.js"></script>
    <script src="assets/vendors/datatables.net/buttons/buttons.bootstrap4.min.js"></script>
    <script src="assets/vendors/datatables.net/buttons/buttons.html5.min.js"></script>
    <script src="assets/vendors/datatables.net/buttons/buttons.print.min.js"></script>
    <script src="assets/vendors/jszip/jszip.min.js"></script>
    <!-- Akhir Berkas Tambahan -->

    <!-- Berkas Pengaturan Umum -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <!-- Akhir Berkas Pengaturan -->

    <!-- Kode Khusus untuk Halaman Ini -->
    <script>
        $(document).ready(function() {
            var tabel = $('#tabel-laporan').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "url": "assets/vendors/datatables.net/Indonesian.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="mdi mdi-file-excel"></i> Unduh Excel',
                        className: 'btn btn-gradient-success',
                        title: 'Laporan Data KRS - Sistem Informasi Akademik',
                        filename: 'Laporan_KRS_<?= date('YmdHis') ?>'
                    },
                    {
                        extend: 'print',
                        text: '<i class="mdi mdi-printer"></i> Cetak',
                        className: 'btn btn-gradient-dark',
                        title: 'Laporan Data KRS',
                        customize: function (win) {
                            $(win.document.body).find('h1').addClass('text-center');
                        }
                    }
                ]
            });

            // Menghubungkan tombol buatan sendiri dengan fungsi bawaan tabel
            $('#tombolExcel').on('click', function(){
                tabel.button('.buttons-excel').trigger();
            });
        });
    </script>
    <!-- Akhir Kode Khusus -->
</body>
</html>