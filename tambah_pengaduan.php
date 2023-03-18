<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

if (isset($_POST['tambah_pengaduan'])) {
  $nama = htmlspecialchars($_POST['nama']);
  $tgl_pengaduan = htmlspecialchars($_POST['tgl_pengaduan']);
  $isi_laporan = htmlspecialchars($_POST['isi_laporan']);
  $status = htmlspecialchars($_POST['status']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halo Dunia</title>
  <link rel="stylesheet" href="./css/global.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <?php include "./components/navbar.php" ?>

  <section id="tambah_pengaduan">
    <div class="container">
      <div class="card">
        <h2 class="card-heading">Isi Pengaduan</h2>
        <div class="card-body">
          <form method="POST" class="form">
            <div class="form-group">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" name="nik" id="nik" class="form-input" value="<?= $_SESSION['user']['nik']; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" name="nama" id="nama" class="form-input" value="<?= $_SESSION['user']['nama']; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="tgl_pengaduan" class="form-label">Tanggal Pengaduan</label>
              <input type="text" name="tgl_pengaduan" id="tgl_pengaduan" class="form-input" value="<?= date('Y-m-d'); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="isi_laporan" class="form-label">Isi Laporan</label>
              <textarea class="form-input" name="isi_laporan" id="isi_laporan" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-input">
                <option value="">Pilih status</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
              </select>
            </div>
            <div class="form-group">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" name="foto" id="foto" class="form-input">
            </div>
            <div class="flex-end">
              <a href="pengaduan.php" class="btn btn-outline-primary">Kembali</a>
              <button type="submit" name="tambah_pengaduan" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>
</body>

</html>