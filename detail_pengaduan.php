<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

$id_pengaduan = $_GET['id_pengaduan'];
$query1 = mysqli_query($conn, "SELECT pengaduan.*, tanggapan.*, petugas.*
                              FROM pengaduan
                              INNER JOIN tanggapan ON pengaduan.id_pengaduan = tanggapan.id_pengaduan
                              INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas
                              WHERE tanggapan.id_pengaduan='$id_pengaduan'");
$query2 = mysqli_query($conn, "SELECT * FROM `pengaduan` WHERE `id_pengaduan`='$id_pengaduan'");

$query = $query1->num_rows > 0 ? $query1 : $query2;

$data = mysqli_fetch_array($query);

if (isset($_POST['ubah_pengaduan'])) {
  $tgl_pengaduan = date("Y-m-d");
  $isi_laporan = htmlspecialchars($_POST['isi_laporan']);
  $foto_lama = htmlspecialchars($_POST['foto_lama']);

  if ($_FILES['foto']['error'] === 4) {
    $foto = $foto_lama;
  } else {
    $nama_file = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $extensi = ['jpg', 'jpeg', 'png'];
    $extUpload = explode('.', $nama_file);
    $extUpload = strtolower(end($extUpload));

    if (!in_array($extUpload, $extensi)) {
      echo "<script>alert('Extensi file tidak didukung!');</script>";
      exit;
    }

    $foto = uniqid() . "." . $extUpload;
    move_uploaded_file($tmp, 'images/' . $foto);
  }

  $query = mysqli_query($conn, "UPDATE `pengaduan` SET `tgl_pengaduan`='$tgl_pengaduan', `isi_laporan`='$isi_laporan', `foto`='$foto' WHERE `id_pengaduan`=$id_pengaduan");

  if ($query) {
    echo "<script>alert('Berhasil ubah pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  } else {
    echo "<script>alert('Gagal ubah pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  }
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

  <section id="detail_pengaduan">
    <div class="container">
      <div class="card">
        <h2 class="card-heading">
          Detail Pengaduan <?= $data['id_pengaduan']; ?>
        </h2>
        <div class="card-body">
          <img src="./images/<?= $data['foto']; ?>" alt="" width="400">
          <h3 style="margin-top: 20px; margin-bottom: 5px; color: var(--primary-color); font-weight: 600;">Isi Laporan</h3>
          <p class="text"><?= $data['isi_laporan']; ?></p>
          <hr style="margin: 10px 0;">
          <h3 style="margin-bottom: 5px; color: var(--primary-color); font-weight: 600;">Tanggapan</h3>
          <?php if (isset($data['nama_petugas']) && isset($data['tanggapan'])) : ?>
            <p class="text">
              <span style="font-weight: bold;"><?= $data['nama_petugas']; ?></span> - <?= $data['tanggapan']; ?>
            </p>
          <?php else : ?>
            <p class="text">
              Belum ada tanggapan
            </p>
          <?php endif; ?>
          <hr style="margin: 10px 0;">
          <h3 style="margin-bottom: 5px; color: var(--primary-color); font-weight: 600;">Status</h3>
          <p class="text"><?= $data['status']; ?></p>
          <div class="flex-end" style="margin-top: 50px;">
            <a href="pengaduan.php" class="btn btn-outline-primary">Kembali</a>
            <button class="btn btn-primary btn-ubah-detail">Ubah</button>
          </div>
        </div>
      </div>
      <div class="card ubah-detail-card hidden">
        <div class="card-body">
          <form method="POST" class="form" enctype="multipart/form-data">
            <div class="form-group">
              <label for="isi_laporan" class="form-label">Isi Laporan</label>
              <textarea class="form-input" name="isi_laporan" id="isi_laporan" cols="30" rows="10"><?= $data['isi_laporan']; ?></textarea>
            </div>
            <input type="hidden" name="foto_lama" value="<?= $data['foto']; ?>">
            <div class="form-group">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" name="foto" id="foto" class="form-input">
            </div>
            <div class="flex-end">
              <button type="submit" name="ubah_pengaduan" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>

  <script>
    const ubahDetailBtn = document.querySelector(".btn-ubah-detail");
    const ubahDetailCard = document.querySelector(".ubah-detail-card");
    ubahDetailBtn.addEventListener("click", () => ubahDetailCard.classList.toggle("hidden"));
  </script>
</body>

</html>