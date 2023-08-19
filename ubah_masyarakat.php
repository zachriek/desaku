<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

if (!isset($_SESSION['user']['level'])) {
  header('Location: index.php');
}

if ($_SESSION['user']['level'] != 'admin') {
  header('Location: index.php');
}

$id_masyarakat = $_GET['id_masyarakat'];
$query = mysqli_query($conn, "SELECT * FROM `masyarakat` WHERE `id`='$id_masyarakat'");

$data = mysqli_fetch_array($query);

if (isset($_POST['ubah_masyarakat'])) {
  $nik =  htmlspecialchars($_POST['nik']);
  $nama = htmlspecialchars($_POST['nama']);
  $username = htmlspecialchars($_POST['username']);
  $telp = htmlspecialchars($_POST['telp']);

  $query = mysqli_query($conn, "UPDATE `masyarakat` SET `nik`='$nik', `nama`='$nama', `username`='$username', `telp`='$telp' WHERE `id`=$id_masyarakat");

  if ($query) {
    echo "<script>alert('Berhasil ubah masyarakat!'); window.location.href = 'masyarakat.php';</script>";
  } else {
    echo "<script>alert('Gagal ubah masyarakat!'); window.location.href = 'masyarakat.php';</script>";
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

  <section id="detail_masyarakat">
    <div class="container">
      <div class="card">
        <h2 class="card-heading">
          Ubah Masyarakat
        </h2>
        <div class="card-body">
          <form method="POST" class="form">
            <div class="form-group">
              <label class="form-label" for="nik">NIK</label>
              <input type="text" class="form-input" name="nik" placeholder="Masukkan NIK" value="<?= $data['nik']; ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="nama">Nama Lengkap</label>
              <input type="text" class="form-input" name="nama" placeholder="Masukkan Nama Lengkap" value="<?= $data['nama']; ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="username">Username</label>
              <input type="text" class="form-input" name="username" placeholder="Masukkan Username" value="<?= $data['username']; ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="telp">Nomor Telepon</label>
              <input type="text" class="form-input" name="telp" placeholder="Masukkan Nomor Telepon" value="<?= $data['telp']; ?>" required>
            </div>
            <div class="flex-end">
              <a href="masyarakat.php" class="btn btn-outline-primary">Kembali</a>
              <button type="submit" name="ubah_masyarakat" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>
</body>

</html>