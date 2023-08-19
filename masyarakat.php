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

if (isset($_POST['tambah_masyarakat'])) {
  $nik =  htmlspecialchars($_POST['nik']);
  $nama = htmlspecialchars($_POST['nama']);
  $username = htmlspecialchars($_POST['username']);
  $password = md5(htmlspecialchars($_POST['password']));
  $telp = htmlspecialchars($_POST['telp']);

  $user = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik' AND username='$username'");

  if ($user->num_rows > 0) {
    echo "<script>alert('Masyarakat sudah terdaftar!');</script>";
  } else {
    $query = mysqli_query($conn, "INSERT INTO `masyarakat`(`id`, `nik`, `nama`, `username`, `password`, `telp`) VALUES ('','$nik','$nama','$username','$password','$telp')");

    if ($query) {
      echo "<script>alert('Berhasil tambah masyarakat!'); window.location.href = 'masyarakat.php';</script>";
    } else {
      echo "<script>alert('Gagal tambah masyarakat!'); window.location.href = 'masyarakat.php';</script>";
    }
  }
}

if (isset($_POST['hapus_masyarakat'])) {
  $id_masyarakat = htmlspecialchars($_POST['id_masyarakat']);

  $query = mysqli_query($conn, "DELETE FROM `masyarakat` WHERE `id`='$id_masyarakat'");

  if ($query) {
    echo "<script>alert('Berhasil hapus masyarakat!'); window.location.href = 'masyarakat.php';</script>";
  } else {
    echo "<script>alert('Gagal hapus masyarakat!'); window.location.href = 'masyarakat.php';</script>";
  }
}

if (isset($_POST['cari_masyarakat'])) {
  $nama_masyarakat = htmlspecialchars($_POST['nama_masyarakat']);

  $query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nama LIKE '%$nama_masyarakat%' OR username LIKE '%$nama_masyarakat%' OR nik LIKE '%$nama_masyarakat%' OR telp LIKE '%$nama_masyarakat%'");
} else {
  $query = mysqli_query($conn, "SELECT * FROM masyarakat");
}

$data_masyarakat = [];
while ($row = mysqli_fetch_assoc($query)) {
  $data_masyarakat[] = $row;
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

  <section id="masyarakat">
    <div class="container">
      <div class="flex-between">
        <h2 class="heading">Masyarakat</h2>
        <button class="btn btn-primary btn-tambah-masyarakat">Tambah Masyarakat</butt>
      </div>
      <div class="card masyarakat-card hidden">
        <div class="card-body">
          <form method="POST" class="form">
            <div class="form-group">
              <label class="form-label" for="nik">NIK</label>
              <input type="text" class="form-input" name="nik" placeholder="Masukkan NIK" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="nama">Nama Lengkap</label>
              <input type="text" class="form-input" name="nama" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="username">Username</label>
              <input type="text" class="form-input" name="username" placeholder="Masukkan Username" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="password">Password</label>
              <input type="password" class="form-input" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="telp">Nomor Telepon</label>
              <input type="text" class="form-input" name="telp" placeholder="Masukkan Nomor Telepon" required>
            </div>
            <div class="flex-end">
              <button type="submit" name="tambah_masyarakat" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <div class="flex-between">
        <form class="form-inline" method="POST">
          <input type="text" class="form-input" name="nama_masyarakat" placeholder="Cari masyarakat...">
          <button type="submit" class="btn btn-primary" name="cari_masyarakat">Cari</button>
        </form>
        <?php if (isset($_SESSION['user']['level'])) : ?>
          <?php if ($_SESSION['user']['level'] == 'admin') : ?>
            <a href="cetak_masyarakat.php" class="btn btn-outline-primary">Cetak</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <?php if (empty($data_masyarakat)) : ?>
        <h3 style="font-weight: 600; color: var(--primary-color); margin-top: 20px;">Data tidak ditemukan</h3>
      <?php else : ?>
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Telp</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_masyarakat as $key => $data) : ?>
              <tr>
                <td><?= ++$key; ?>.</td>
                <td><?= $data['nik']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['username']; ?></td>
                <td><?= $data['telp']; ?></td>
                <td>
                  <form method="POST">
                    <input type="hidden" name="id_masyarakat" value="<?= $data['id']; ?>">
                    <button type="submit" name="hapus_masyarakat" class=" btn btn-outline-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus?');">Hapus</button>
                  </form>
                  <a href="ubah_masyarakat.php?id_masyarakat=<?= $data['id'] ?>" class="btn btn-primary">Ubah</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>

  <script>
    const tambahMasyarakatBtn = document.querySelector(".btn-tambah-masyarakat");
    const masyarakatCard = document.querySelector(".masyarakat-card");
    tambahMasyarakatBtn.addEventListener("click", () => masyarakatCard.classList.toggle("hidden"));
  </script>
</body>

</html>