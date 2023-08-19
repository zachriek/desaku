<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

if (!isset($_SESSION['user']['level'])) {
  header("Location: pengaduan.php");
}

$query = mysqli_query($conn, "SELECT * FROM pengaduan");
$data_pengaduan = [];
while ($row = mysqli_fetch_assoc($query)) {
  $data_pengaduan[] = $row;
}

if (isset($_POST['tanggap'])) {
  $id_pengaduan = $_GET['id_pengaduan'];
  $id_petugas = $_SESSION['user']['id_petugas'];
  $tgl_tanggapan = date("Y-m-d");
  $tanggapan = htmlspecialchars($_POST['tanggapan']);
  $status = htmlspecialchars($_POST['status']);

  $cek_tanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan=$id_pengaduan");

  if ($cek_tanggapan->num_rows > 0) {
    $query = mysqli_query($conn, "UPDATE `tanggapan` SET `tanggapan`='$tanggapan', `tgl_tanggapan`='$tgl_tanggapan' WHERE `id_pengaduan`=$id_pengaduan");
  } else {
    $query = mysqli_query($conn, "INSERT INTO `tanggapan`(`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `tanggapan`, `id_petugas`) VALUES ('','$id_pengaduan','$tgl_tanggapan','$tanggapan','$id_petugas')");
  }

  $query2 = mysqli_query($conn, "UPDATE `pengaduan` SET `status`='$status' WHERE `id_pengaduan`=$id_pengaduan");

  if ($query && $query2) {
    echo "<script>alert('Berhasil tanggap!'); window.location.href = 'pengaduan.php';</script>";
  } else {
    echo "<script>alert('Gagal tanggap!'); window.location.href = 'pengaduan.php';</script>";
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

  <section id="pengaduan">
    <div class="container">
      <div class="card pengaduan-card">
        <h2 class="card-heading">Tanggap Pengaduan</h2>
        <div class="card-body">
          <form method="POST" class="form">
            <div class="form-group">
              <label for="tanggapan" class="form-label">Tanggapan</label>
              <textarea class="form-input" name="tanggapan" id="tanggapan" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-input">
                <option value="">Pilih Status</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
              </select>
            </div>
            <div class="flex-end">
              <a href="pengaduan.php" class="btn btn-outline-primary">Kembali</a>
              <button type="submit" name="tanggap" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>
</body>

</html>