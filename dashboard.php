<?php
include 'koneksi.php';

// ==========================================
// MENGHITUNG JUMLAH DATA UNTUK KARTU INFORMASI
// ==========================================
$jumlah_mahasiswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa"));
$jumlah_dosen     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dim_dosen"));
$jumlah_mk        = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dim_matakuliah"));
$jumlah_semester  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dim_semester"));
$jumlah_krs       = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM fact_krs"));

// Menghitung persentase perubahan mahasiswa dibanding tahun sebelumnya
$thn_terakhir_sql = mysqli_query($koneksi, "SELECT MAX(angkatan) AS tahun FROM dim_mahasiswa");
$thn_terakhir     = mysqli_fetch_assoc($thn_terakhir_sql)['tahun'];
$thn_sebelumnya   = $thn_terakhir - 1;

$jml_thn_terakhir_sql    = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa WHERE angkatan = '$thn_terakhir'");
$jml_thn_terakhir        = mysqli_num_rows($jml_thn_terakhir_sql);
$jml_thn_sebelumnya_sql  = mysqli_query($koneksi, "SELECT * FROM dim_mahasiswa WHERE angkatan = '$thn_sebelumnya'");
$jml_thn_sebelumnya      = mysqli_num_rows($jml_thn_sebelumnya_sql);

if($jml_thn_sebelumnya > 0){
    $persen_mhs = round((($jml_thn_terakhir - $jml_thn_sebelumnya) / $jml_thn_sebelumnya) * 100);
} else {
    $persen_mhs = 100;
}

// Menghitung persentase perubahan data KRS dibanding semester sebelumnya
$smt_terakhir_sql = mysqli_query($koneksi, "SELECT id_semester FROM dim_semester ORDER BY tahun_ajaran DESC, semester DESC LIMIT 1");
$smt_terakhir     = mysqli_fetch_assoc($smt_terakhir_sql)['id_semester'];
$smt_sebelumnya_sql = mysqli_query($koneksi, "SELECT id_semester FROM dim_semester ORDER BY tahun_ajaran DESC, semester DESC LIMIT 1,1");
$smt_sebelumnya     = mysqli_fetch_assoc($smt_sebelumnya_sql)['id_semester'];

$jml_smt_terakhir_sql   = mysqli_query($koneksi, "SELECT * FROM fact_krs WHERE id_semester = '$smt_terakhir'");
$jml_smt_terakhir       = mysqli_num_rows($jml_smt_terakhir_sql);
$jml_smt_sebelumnya_sql = mysqli_query($koneksi, "SELECT * FROM fact_krs WHERE id_semester = '$smt_sebelumnya'");
$jml_smt_sebelumnya     = mysqli_num_rows($jml_smt_sebelumnya_sql);

if($jml_smt_sebelumnya > 0){
    $persen_krs = round((($jml_smt_terakhir - $jml_smt_sebelumnya) / $jml_smt_sebelumnya) * 100);
} else {
    $persen_krs = 100;
}

// ==========================================
// DATA UNTUK GRAFIK BATANG (PERBANDINGAN PER SEMESTER)
// ==========================================
$grafik_data_sql = mysqli_query($koneksi, "
    SELECT 
        ds.semester, 
        ds.tahun_ajaran,
        COUNT(DISTINCT fk.id_krs) AS total_krs,
        COUNT(DISTINCT CASE WHEN mhs.angkatan = SUBSTRING(ds.tahun_ajaran, 1,4) THEN mhs.id_mahasiswa END) AS total_mahasiswa,
        COUNT(DISTINCT mk.id_Matakuliah) AS total_mk
    FROM dim_semester ds
    LEFT JOIN fact_krs fk ON ds.id_semester = fk.id_semester
    LEFT JOIN dim_mahasiswa mhs ON fk.id_mahasiswa = mhs.id_mahasiswa
    LEFT JOIN dim_matakuliah mk ON fk.id_Matakuliah = mk.id_Matakuliah
    GROUP BY ds.id_semester
    ORDER BY ds.tahun_ajaran ASC, ds.semester ASC
");

$nama_periode = [];
$data_mahasiswa = [];
$data_matakuliah = [];
$data_krs = [];

while($row = mysqli_fetch_assoc($grafik_data_sql)){
    $nama_periode[]     = $row['semester'] . ' ' . $row['tahun_ajaran'];
    $data_mahasiswa[]   = $row['total_mahasiswa'] ?? 0;
    $data_matakuliah[]  = $row['total_mk'] ?? 0;
    $data_krs[]         = $row['total_krs'] ?? 0;
}

// ==========================================
// DATA UNTUK GRAFIK LINGKARAN (PERSENTASE BERDASARKAN JURUSAN)
// ==========================================
$lingkaran_sql = mysqli_query($koneksi, "SELECT prodi, COUNT(*) AS jumlah FROM dim_mahasiswa GROUP BY prodi");
$nama_prodi = [];
$jumlah_prodi = [];

while($data_prodi = mysqli_fetch_assoc($lingkaran_sql)){
    $nama_prodi[]   = $data_prodi['prodi'];
    $jumlah_prodi[] = $data_prodi['jumlah'];
}

// ==========================================
// DATA RIWAYAT AKTIVITAS TERAKHIR
// ==========================================
$riwayat_aktivitas = [
    [
        'pelaksana' => 'Admin Akademik',
        'kegiatan'  => 'Menambahkan data mahasiswa baru',
        'status'    => 'SELESAI',
        'tanggal'   => '1 Mei 2026',
        'kode'      => 'DW-00001'
    ],
    [
        'pelaksana' => 'Admin Akademik',
        'kegiatan'  => 'Mengubah informasi mata kuliah',
        'status'    => 'SEDANG DIPROSES',
        'tanggal'   => '30 April 2026',
        'kode'      => 'DW-00002'
    ],
    [
        'pelaksana' => 'Admin Akademik',
        'kegiatan'  => 'Menghapus data semester lama',
        'status'    => 'DITANGGUHKAN',
        'tanggal'   => '29 April 2026',
        'kode'      => 'DW-00003'
    ],
    [
        'pelaksana' => 'Admin Akademik',
        'kegiatan'  => 'Mengekspor laporan data KRS',
        'status'    => 'DIBATALKAN',
        'tanggal'   => '28 April 2026',
        'kode'      => 'DW-00004'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Pengaturan dasar -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dasbor - Gudang Data Akademik</title>
    
    <!-- Berkas Gaya Tampilan -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- Bagian Atas -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo" href="dashboard.php"><h3>DW Akademik</h3></a>
                <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
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
                            <input type="text" class="form-control bg-transparent border-0" placeholder="Cari data...">
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
                                <i class="mdi mdi-cached me-2 text-success"></i> Catatan Aktivitas
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="login.php">
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
                        <a class="nav-link" href="login.php">
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
            <!-- Menu Samping -->
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
            <!-- Akhir Menu Samping -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span> Dasbor
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span>Ikhtisar</span> <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Bagian Kartu Informasi -->
                    <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white">
                                <div class="card-body">
                         <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="lingkaran gambar" />
                                    <h4 class="font-weight-normal mb-3">Jumlah Mahasiswa <i class="mdi mdi-account-group mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"><?= $jumlah_mahasiswa ?> Orang</h2>
                                    <h6 class="card-text">
                                        <?php if($persen_mhs >= 0): ?>
                                            Meningkat sebesar <?= $persen_mhs ?>% dari tahun sebelumnya
                                        <?php else: ?>
                                            Menurun sebesar <?= abs($persen_mhs) ?>% dari tahun sebelumnya
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="lingkaran gambar" />
                                    <h4 class="font-weight-normal mb-3">Jumlah Mata Kuliah <i class="mdi mdi-book-variant mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"><?= $jumlah_mk ?> Mata Kuliah</h2>
                                    <h6 class="card-text">Tersedia untuk seluruh tingkat semester</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">
                                <div class="card-body">
                                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="lingkaran gambar" />
                                    <h4 class="font-weight-normal mb-3">Jumlah Data KRS <i class="mdi mdi-clipboard-check mdi-24px float-end"></i></h4>
                                    <h2 class="mb-5"><?= $jumlah_krs ?> Data</h2>
                                    <h6 class="card-text">
                                        <?php if($persen_krs >= 0): ?>
                                            Bertambah sebesar <?= $persen_krs ?>% dari semester lalu
                                        <?php else: ?>
                                            Berkurang sebesar <?= abs($persen_krs) ?>% dari semester lalu
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Bagian Kartu Informasi -->

                    <!-- Bagian Grafik Batang & Lingkaran -->
                    <div class="row">
                        <div class="col-md-7 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <h4 class="card-title float-start">Perbandingan Data Akademik Periode</h4>
                                        <div id="grafik-batang-keterangan" class="rounded-keterangan keterangan-mendatar keterangan-atas-kanan float-end"></div>
                                    </div>
                                    <canvas id="grafikBatang" class="mt-4"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Persentase Mahasiswa Berdasarkan Jurusan</h4>
                                    <div class="lingkaran-grafik pembungkus-d-flex penyelarasan-tengah">
                                        <canvas id="grafikLingkaran"></canvas>
                                    </div>
                                    <div id="grafik-lingkaran-keterangan" class="rounded-keterangan keterangan-tegak keterangan-bawah-kiri pt-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Bagian Grafik -->

                    <!-- Bagian Riwayat Aktivitas -->
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Riwayat Aktivitas Terkini</h4>
                                    <div class="tabel-dapat-gulir">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Pelaksana</th>
                                                    <th>Kegiatan Dilakukan</th>
                                                    <th>Status</th>
                                                    <th>Terakhir Diubah</th>
                                                    <th>Kode Lacak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($riwayat_aktivitas as $riwayat): ?>
                                                <tr>
                                                    <td>
                                                        <img src="f1.jpg" class="me-2 rounded-circle" width="30" height="30" alt="gambar pelaksana">
                                                        <?= $riwayat['pelaksana'] ?>
                                                    </td>
                                                    <td><?= $riwayat['kegiatan'] ?></td>
                                                    <td>
                                                        <?php if($riwayat['status'] == 'SELESAI'): ?>
                                                            <label class="lencana lencana-lulus-bertingkat"><?= $riwayat['status'] ?></label>
                                                        <?php elseif($riwayat['status'] == 'SEDANG DIPROSES'): ?>
                                                            <label class="lencana lencana-peringatan-bertingkat"><?= $riwayat['status'] ?></label>
                                                        <?php elseif($riwayat['status'] == 'DITANGGUHKAN'): ?>
                                                            <label class="lencana lencana-informasi-bertingkat"><?= $riwayat['status'] ?></label>
                                                        <?php else: ?>
                                                            <label class="lencana lencana-bahaya-bertingkat"><?= $riwayat['status'] ?></label>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $riwayat['tanggal'] ?></td>
                                                    <td><?= $riwayat['kode'] ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Bagian Riwayat -->

                </div>
                <!-- Penutup Isi Utama -->

                <!-- Bagian Bawah -->
                <footer class="penjelang">
                    <div class="d-sm-flex menyelaraskan-tengah menyelaraskan-kiri-kanan-sm">
                        <span class="teks-teduh teks-tengah teks-kiri-sm blok-d-sm-sebaris">
                            Hak Cipta © 2026 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. Semua hak dilindungi undang-undang. Sebarkan oleh <a href="http://themewagon.com" target="_blank">ThemeWagon</a>
                        </span>
                        <span class="melayang-tidak-ada melayang-kanan-sm blok-mt-1 mt-sm-0 teks-tengah">
                            Dibuat sepenuh hati <i class="mdi mdi-hati teks-bahaya"></i> oleh Admin Akademik
                        </span>
                    </div>
                </footer>
                <!-- Akhir Bagian Bawah -->
            </div>
            <!-- Penutup Panel Utama -->
        </div>
        <!-- Penutup Isi Halaman -->
    </div>
    <!-- Penutup Seluruh Wadah -->

    <!-- Berkas Skrip Pendukung -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/pengaturan.js"></script>
    <script src="assets/js/daftar-tugas.js"></script>
    <script src="assets/js/kue-jquery.js"></script>

    <!-- Pengaturan Grafik -->
    <script>
        // Grafik Batang
        var grafikBatang = document.getElementById('grafikBatang').getContext('2d');
        new Chart(grafikBatang, {
            type: 'bar',
            data: {
                labels: <?= json_encode($nama_periode) ?>,
                datasets: [
                    {
                        label: 'Jumlah Mahasiswa',
                        data: <?= json_encode($data_mahasiswa) ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Mata Kuliah',
                        data: <?= json_encode($data_matakuliah) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Data KRS',
                        data: <?= json_encode($data_krs) ?>,
                        backgroundColor: 'rgba(255, 159, 64, 0.7)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Lingkaran
        var grafikLingkaran = document.getElementById('grafikLingkaran').getContext('2d');
        new Chart(grafikLingkaran, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($nama_prodi) ?>,
                datasets: [{
                    data: <?= json_encode($jumlah_prodi) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>