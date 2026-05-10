<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Data Mahasiswa</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container-scroller">

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-plus"></i>
            </span> Tambah Data Mahasiswa
          </h3>
        </div>

        <div class="row">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Form Input Data</h4>
                
                <!-- FORM INPUT -->
                <form class="forms-sample" method="POST" action="proses_tambah.php">
                  
                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                  </div>

                  <div class="form-group">
                    <label for="prodi">Program Studi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan prodi" required>
                  </div>

                  <div class="form-group">
                    <label for="fakultas">Fakultas</label>
                    <input type="text" class="form-control" id="fakultas" name="fakultas" placeholder="Masukkan fakultas" required>
                  </div>

                  <div class="form-group">
                    <label for="angkatan">Angkatan</label>
                    <input type="number" class="form-control" id="angkatan" name="angkatan" placeholder="Contoh: 2021" required>
                  </div>

                  <button type="submit" class="btn btn-gradient-primary me-2">
                    <i class="mdi mdi-content-save"></i> Simpan Data
                  </button>
                  <a href="data mahasiswa.php" class="btn btn-light">
                    <i class="mdi mdi-arrow-left"></i> Batal
                  </a>

                </form>

              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- FOOTER -->
      <footer class="footer">
        <div class="d-sm-flex justify-content-center">
          <span class="text-muted">Copyright © 2025 DW Akademik</span>
        </div>
      </footer>

    </div>
  </div>

  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/misc.js"></script>
</body>
</html>