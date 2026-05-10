<?php
include 'koneksi.php';

// Ambil seluruh data KRS beserta data rujukan dari tabel induk
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

// Pengaturan agar berkas yang diunduh berformat Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Data_KRS_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data KRS</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }
        th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: center;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="judul">
    LAPORAN SELURUH DATA KARTU RENCANA STUDI (KRS)<br>
    SISTEM GUDANG DATA AKADEMIK<br>
    Tanggal Cetak : <?= date('d-m-Y H:i') ?>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID KRS</th>
            <th>ID Mahasiswa</th>
            <th>Nama Mahasiswa</th>
            <th>Program Studi</th>
            <th>Fakultas</th>
            <th>Angkatan</th>
            <th>ID Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>ID Dosen</th>
            <th>Nama Dosen</th>
            <th>ID Waktu</th>
            <th>Tahun Waktu</th>
            <th>Bulan Waktu</th>
            <th>ID Semester</th>
            <th>Semester</th>
            <th>Tahun Ajaran</th>
            <th>SKS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_array($data_krs)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $data['id_krs'] ?></td>
            <td><?= $data['id_mahasiswa'] ?></td>
            <td><?= $data['nama_mahasiswa'] ?></td>
            <td><?= $data['prodi'] ?></td>
            <td><?= $data['fakultas'] ?></td>
            <td><?= $data['angkatan'] ?></td>
            <td><?= $data['id_Matakuliah'] ?></td>
            <td><?= $data['nama_Matakuliah'] ?></td>
            <td><?= $data['id_dosen'] ?></td>
            <td><?= $data['nama_dosen'] ?></td>
            <td><?= $data['id_Waktu'] ?></td>
            <td><?= $data['tahun_waktu'] ?></td>
            <td><?= $data['bulan_waktu'] ?></td>
            <td><?= $data['id_semester'] ?></td>
            <td><?= $data['semester'] ?></td>
            <td><?= $data['tahun_ajaran'] ?></td>
            <td><?= $data['sks'] ?></td>
        </tr>
        <?php
        }
        if (mysqli_num_rows($data_krs) == 0) {
            echo "<tr><td colspan='18' align='center'>Belum ada data yang tersedia</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>