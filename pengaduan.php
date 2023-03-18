<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
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

  <section id="pengaduan">
    <div class="container">
      <div class="flex-between">
        <h2 class="heading">Pengaduan</h2>
        <a href="tambah_pengaduan.php" class="btn btn-primary">Isi Pengaduan</a>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Isi Laporan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1.</td>
            <td>
              <img width="100" src="./images/images (2).jpeg" alt="image">
            </td>
            <td>
              <?= $_SESSION['user']['nama']; ?>
            </td>
            <td>Status</td>
            <td>Isi Laporan</td>
            <td>
              <a href="detail_pengaduan.php" class="btn btn-primary">Lihat</a>
            </td>
          </tr>
          <tr>
            <td>1.</td>
            <td>
              <img width="100" src="./images/images (2).jpeg" alt="image">
            </td>
            <td>
              <?= $_SESSION['user']['nama']; ?>
            </td>
            <td>Status</td>
            <td>Isi Laporan</td>
            <td>
              <a href="detail_pengaduan.php" class="btn btn-primary">Lihat</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>
</body>

</html>