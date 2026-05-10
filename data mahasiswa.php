<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- NAVBAR -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="index.html"><h3>Data Mahasiswa</h3></a>
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
                <p class="mb-1 text-black">David Greymaax</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
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

    <div class="container-fluid page-body-wrapper">
      <!-- SIDEBAR -->
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

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
              </span> Data Mahasiswa
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">

                  <!-- TOMBOL ATAS -->
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                      <button class="btn btn-gradient-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                        <i class="mdi mdi-plus"></i> Tambah Data
                      </button>
                      <button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#formFilter">
                        <i class="mdi mdi-filter"></i> Filter
                      </button>
                    </div>
                    <a href="export_excel.php" class="btn btn-success">
                      <i class="mdi mdi-file-excel"></i> Export Excel
                    </a>
                  </div>

                  <!-- FORM FILTER RAPI -->
                  <div class="collapse mb-3" id="formFilter">
                    <div class="card card-body">
                      <form method="GET" action="">
                        <div class="row">
                          <div class="col-md-3">
                            <select name="prodi" class="form-control">
                              <option value="">-- Pilih Program Studi --</option>
                              <option value="Teknik Informatika">Teknik Informatika</option>
                              <option value="Sistem Informasi">Sistem Informasi</option>
                              <option value="Teknik Komputer">Teknik Komputer</option>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <select name="angkatan" class="form-control">
                              <option value="">-- Pilih Angkatan --</option>
                              <?php 
                                for($i=date('Y'); $i>=2018; $i--){
                                  echo "<option value='$i'>$i</option>";
                                }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            <a href="data mahasiswa.php" class="btn btn-secondary">Reset</a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <h4 class="card-title">Tabel dim_mahasiswa</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama Lengkap</th>
                          <th>Program Studi</th>
                          <th>Fakultas</th>
                          <th>Angkatan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          include 'koneksi.php';
                          
                          $sql = "SELECT * FROM dim_mahasiswa";
                          
                          if(isset($_GET['prodi']) && $_GET['prodi'] != ""){
                            $prodi = $_GET['prodi'];
                            $sql = "SELECT * FROM dim_mahasiswa WHERE prodi = '$prodi'";
                          }
                          
                          if(isset($_GET['angkatan']) && $_GET['angkatan'] != ""){
                            $angkatan = $_GET['angkatan'];
                            $sql = "SELECT * FROM dim_mahasiswa WHERE angkatan = '$angkatan'";
                          }
                          
                          if(isset($_GET['prodi']) && $_GET['prodi'] != "" && isset($_GET['angkatan']) && $_GET['angkatan'] != ""){
                            $prodi = $_GET['prodi'];
                            $angkatan = $_GET['angkatan'];
                            $sql = "SELECT * FROM dim_mahasiswa WHERE prodi = '$prodi' AND angkatan = '$angkatan'";
                          }

                          $no = 1;
                          $data = mysqli_query($koneksi, $sql);
                          while($d = mysqli_fetch_array($data)){
                        ?>

                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['id_mahasiswa']; ?></td>
                          <td><?php echo $d['nama']; ?></td>
                          <td><?php echo $d['prodi']; ?></td>
                          <td><?php echo $d['fakultas']; ?></td>
                          <td><?php echo $d['angkatan']; ?></td>
                          <td>
                            <a href="edit_mahasiswa.php?id=<?php echo $d['id_mahasiswa']; ?>" class="badge badge-gradient-info">Edit</a>
                            <a href="hapus_mahasiswa.php?id=<?php echo $d['id_mahasiswa']; ?>" class="badge badge-gradient-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                          </td>
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

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved. Distributed by <a href="http://themewagon.com" target="_blank">ThemeWagon</a></span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- MODAL TAMBAH DATA -->
  <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary text-white">
          <h5 class="modal-title">
            <i class="mdi mdi-plus-circle"></i> Tambah Data Mahasiswa
          </h5>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <form action="simpan_mahasiswa.php" method="POST">
            
            <div class="form-group">
              <label>NIM (ID Mahasiswa)</label>
              <input type="text" name="id_mahasiswa" class="form-control" placeholder="Masukkan NIM" required>
            </div>

            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
              <label>Program Studi</label>
              <input type="text" name="prodi" class="form-control" placeholder="Masukkan program studi" required>
            </div>

            <div class="form-group">
              <label>Fakultas</label>
              <input type="text" name="fakultas" class="form-control" placeholder="Masukkan fakultas" required>
            </div>

            <div class="form-group">
              <label>Angkatan</label>
              <input type="number" name="angkatan" class="form-control" placeholder="Contoh: 2021" required>
            </div>

        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-gradient-primary">Simpan Data</button>
        </div>
        
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/misc.js"></script>
</body>
</html>