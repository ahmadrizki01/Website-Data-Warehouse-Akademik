<?php
include 'koneksi.php';

// Ambil seluruh data KRS digabung dengan tabel induknya agar tampil nama, bukan hanya kode
$data_krs = mysqli_query($koneksi, "
    SELECT 
        fk.id_krs,
        m.id_mahasiswa,
        m.nama AS nama_mahasiswa,
        m.prodi,
        m.fakultas,
        m.angkatan,
        mk.id_Matakuliah,
        mk.nama_Matakuliah,
        dsn.id_dosen,
        dsn.nama_dosen,
        wk.id_Waktu,
        wk.tahun AS tahun_waktu,
        wk.bulan AS bulan_waktu,
        smt.id_semester,
        smt.semester,
        smt.tahun_ajaran,
        fk.sks
    FROM fact_krs fk
    JOIN dim_mahasiswa m ON fk.id_mahasiswa = m.id_mahasiswa
    JOIN dim_matakuliah mk ON fk.id_Matakuliah = mk.id_Matakuliah
    JOIN dim_dosen dsn ON fk.id_dosen = dsn.id_dosen
    JOIN dim_waktu wk ON fk.id_Waktu = wk.id_Waktu
    JOIN dim_semester smt ON fk.id_semester = smt.id_semester
    ORDER BY fk.id_krs DESC
");

// Ambil data untuk pilihan di formulir
$mahasiswa = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa ORDER BY nama ASC");
$matakuliah = mysqli_query($koneksi, "SELECT * FROM dim_matakuliah ORDER BY nama_Matakuliah ASC");
$dosen = mysqli_query($koneksi, "SELECT * FROM dim_dosen ORDER BY nama_dosen ASC");
$waktu = mysqli_query($koneksi, "SELECT * FROM dim_waktu ORDER BY tahun DESC, bulan DESC");
$semester = mysqli_query($koneksi, "SELECT * FROM dim_semester ORDER BY tahun_ajaran DESC");

// Proses simpan data jika tombol diklik
if(isset($_POST['simpan'])){
    $id_mahasiswa    = $_POST['id_mahasiswa'];
    $id_Matakuliah   = $_POST['id_Matakuliah'];
    $id_dosen        = $_POST['id_dosen'];
    $id_Waktu        = $_POST['id_Waktu'];
    $id_semester     = $_POST['id_semester'];
    $sks             = $_POST['sks'];

  // Buat ID KRS otomatis
$ambil_id = mysqli_query($koneksi, "SELECT id_krs FROM fact_krs ORDER BY id_krs DESC LIMIT 1");
$data_id = mysqli_fetch_array($ambil_id);

if($data_id){
    // Ambil bagian angka saja setelah "KRS", lalu ubah jadi integer
    $nomor_terakhir = intval(substr($data_id['id_krs'], 3));
    $urut = $nomor_terakhir + 1;
} else {
    $urut = 1;
}

// Format jadi KRS000001, KRS000002, dst
$id_baru = "KRS" . str_pad($urut, 6, "0", STR_PAD_LEFT);

    $simpan = mysqli_query($koneksi, "INSERT INTO fact_krs (id_krs, id_mahasiswa, id_Matakuliah, id_dosen, id_Waktu, id_semester, sks) 
    VALUES ('$id_baru','$id_mahasiswa','$id_Matakuliah','$id_dosen','$id_Waktu','$id_semester','$sks')");

    if($simpan){
        echo "<script>alert('Data KRS berhasil disimpan!'); window.location='lihat data krs.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data! ".mysqli_error($koneksi)."'); window.history.back();</script>";
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
                  <i class="mdi mdi-clipboard-text"></i>
                </span> Daftar Data KRS
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Data KRS</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lihat Data KRS</li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="card-title mb-0">Seluruh Data Kartu Rencana Studi</h4>
                      <div>
                        <!-- TOMBOL UNTUK MEMUNCULKAN JENDELA SEMBUL -->
                        <button type="button" class="btn btn-gradient-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahData">
                          <i class="mdi mdi-plus me-1"></i> Tambah Data
                        </button>
                        <a href="export_krs.php" class="btn btn-gradient-success btn-sm ms-1">
                          <i class="mdi mdi-file-excel me-1"></i> Ekspor Excel
                        </a>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered" id="tabel-krs">
                        <thead class="table-primary">
                          <tr>
                            <th>No</th>
                            <th>ID KRS</th>
                            <th>Data Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th>Waktu</th>
                            <th>Semester & Tahun Ajaran</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $no = 1;
                          while($data = mysqli_fetch_array($data_krs)){
                          ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['id_krs'] ?></td>
                            <td>
                              <small>
                                <b>ID :</b> <?= $data['id_mahasiswa'] ?><br>
                                <b>Nama :</b> <?= $data['nama_mahasiswa'] ?><br>
                                <b>Prodi :</b> <?= $data['prodi'] ?><br>
                                <b>Fakultas :</b> <?= $data['fakultas'] ?><br>
                                <b>Angkatan :</b> <?= $data['angkatan'] ?>
                              </small>
                            </td>
                            <td>
                              <small>
                                <b>Kode :</b> <?= $data['id_Matakuliah'] ?><br>
                                <b>Nama :</b> <?= $data['nama_Matakuliah'] ?>
                              </small>
                            </td>
                            <td><?= $data['nama_dosen'] ?></td>
                            <td>
                              <small>
                                <b>Tahun :</b> <?= $data['tahun_waktu'] ?><br>
                                <b>Bulan :</b> <?= $data['bulan_waktu'] ?>
                              </small>
                            </td>
                            <td>
                              <?= $data['semester'] ?> - <?= $data['tahun_ajaran'] ?>
                            </td>
                            <td><?= $data['sks'] ?></td>
                            <td>
                              <a href="edit_krs.php?id=<?= $data['id_krs'] ?>" class="btn btn-gradient-info btn-icon-text btn-sm mb-1">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i> Ubah
                              </a>
                              <a href="hapus_krs.php?id=<?= $data['id_krs'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-gradient-danger btn-icon-text btn-sm">
                                <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                          <?php if(mysqli_num_rows($data_krs) == 0){ ?>
                            <tr>
                              <td colspan="9" class="text-center text-muted">Belum ada data KRS yang tercatat</td>
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

          <!-- JENDELA SEMBUL TAMBAH DATA KRS -->
          <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #b664f9, #7b52f5); color: white; border-bottom: none;">
                  <h5 class="modal-title" id="tambahDataLabel"><i class="mdi mdi-plus-circle me-2"></i>Tambah Data KRS</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form method="POST" action="">
                  <div class="modal-body" style="background-color: #f8f9fa;">
                    <div class="form-group mb-3">
                      <label class="form-label">Pilih Mahasiswa <span class="text-danger">*</span></label>
                      <select name="id_mahasiswa" class="form-control" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        <?php foreach($mahasiswa as $mhs){ ?>
                        <option value="<?= $mhs['id_mahasiswa'] ?>"><?= $mhs['id_mahasiswa'] ?> - <?= $mhs['nama'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label class="form-label">Pilih Mata Kuliah <span class="text-danger">*</span></label>
                      <select name="id_Matakuliah" class="form-control" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php foreach($matakuliah as $mk){ ?>
                        <option value="<?= $mk['id_Matakuliah'] ?>"><?= $mk['id_Matakuliah'] ?> - <?= $mk['nama_Matakuliah'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label class="form-label">Pilih Dosen Pengampu <span class="text-danger">*</span></label>
                      <select name="id_dosen" class="form-control" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                        <option value="">-- Pilih Dosen --</option>
                        <?php foreach($dosen as $dsn){ ?>
                        <option value="<?= $dsn['id_dosen'] ?>"><?= $dsn['id_dosen'] ?> - <?= $dsn['nama_dosen'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label class="form-label">Pilih Waktu KRS <span class="text-danger">*</span></label>
                      <select name="id_Waktu" class="form-control" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                        <option value="">-- Pilih Waktu --</option>
                        <?php foreach($waktu as $wt){ ?>
                        <option value="<?= $wt['id_Waktu'] ?>"><?= $wt['tahun'] ?> - <?= $wt['bulan'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label class="form-label">Pilih Semester & Tahun Ajaran <span class="text-danger">*</span></label>
                      <select name="id_semester" class="form-control" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                        <option value="">-- Pilih Semester --</option>
                        <?php foreach($semester as $smt){ ?>
                        <option value="<?= $smt['id_semester'] ?>"><?= $smt['semester'] ?> - <?= $smt['tahun_ajaran'] ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label class="form-label">Jumlah SKS <span class="text-danger">*</span></label>
                      <input type="number" name="sks" class="form-control" min="1" max="6" placeholder="Masukkan jumlah SKS" style="border-radius: 8px; border: 1px solid #ddd; padding: 10px;" required>
                    </div>
                  </div>
                  <div class="modal-footer" style="border-top: none; background-color: #f8f9fa; justify-content: space-between;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; padding: 8px 20px;">
                      <i class="mdi mdi-close me-1"></i> Batal
                    </button>
                    <button type="submit" name="simpan" class="btn" style="background: linear-gradient(135deg, #b664f9, #7b52f5); color: white; border-radius: 8px; padding: 8px 20px;">
                      <i class="mdi mdi-content-save me-1"></i> Simpan Data
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- AKHIR JENDELA SEMBUL -->

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
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
      $(document).ready(function() {
        $('#tabel-krs').DataTable({
          "language": {
            "sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ entri",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari:",
            "sUrl":          "",
            "oPaginate": {
              "sFirst":    "Pertama",
              "sPrevious": "Sebelumnya",
              "sNext":     "Selanjutnya",
              "sLast":     "Terakhir"
            }
          }
        });
      });
    </script>
    <!-- End custom js for this page -->
  </body>
</html>