<?php

include "koneksi.php";

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

if (isset($_POST['tambah_pengaduan'])) {
  $nik = $_SESSION['user']['nik'];
  $nama = $_SESSION['user']['nama'];
  $tgl_pengaduan = date("Y-m-d");
  $isi_laporan = htmlspecialchars($_POST['isi_laporan']);
  $status = 'proses';

  if ($_FILES['foto']['error'] === 4) {
    $foto = '';
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

  $query = mysqli_query($conn, "INSERT INTO `pengaduan`(`id_pengaduan`, `tgl_pengaduan`, `nik`, `isi_laporan`, `foto`, `status`) VALUES ('','$tgl_pengaduan','$nik','$isi_laporan','$foto','$status')");

  if ($query) {
    echo "<script>alert('Berhasil isi pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  } else {
    echo "<script>alert('Gagal isi pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  }
}

if (isset($_POST['hapus_pengaduan'])) {
  $id_pengaduan = htmlspecialchars($_POST['id_pengaduan']);

  $cek_foto = mysqli_query($conn, "SELECT foto FROM `pengaduan` WHERE `id_pengaduan`='$id_pengaduan'");

  if ($cek_foto) {
    $foto = mysqli_fetch_array($cek_foto);
    unlink("images/" . $foto['foto']);
  }

  $query = mysqli_query($conn, "DELETE FROM `pengaduan` WHERE `id_pengaduan`='$id_pengaduan'");

  if ($query) {
    echo "<script>alert('Berhasil hapus pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  } else {
    echo "<script>alert('Gagal hapus pengaduan!'); window.location.href = 'pengaduan.php';</script>";
  }
}

if (isset($_POST['cari_pengaduan'])) {
  $isi_laporan_pengaduan = htmlspecialchars($_POST['isi_laporan_pengaduan']);

  $query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE isi_laporan LIKE '%$isi_laporan_pengaduan%'");
} else {
  $query = mysqli_query($conn, "SELECT * FROM pengaduan");
}

$data_pengaduan = [];
while ($row = mysqli_fetch_assoc($query)) {
  $data_pengaduan[] = $row;
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
        <button class="btn btn-primary btn-isi-pengaduan">Isi Pengaduan</butt>
      </div>
      <div class="card pengaduan-card hidden">
        <div class="card-body">
          <form method="POST" class="form" enctype="multipart/form-data">
            <div class="form-group">
              <label for="isi_laporan" class="form-label">Isi Laporan</label>
              <textarea class="form-input" name="isi_laporan" id="isi_laporan" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
              <label for="foto" class="form-label">Foto</label>
              <input type="file" name="foto" id="foto" class="form-input">
            </div>
            <div class="flex-end">
              <button type="submit" name="tambah_pengaduan" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <div class="flex-between">
        <form class="form-inline" method="POST">
          <input type="text" class="form-input" name="isi_laporan_pengaduan" placeholder="Cari pengaduan...">
          <button type="submit" class="btn btn-primary" name="cari_pengaduan">Cari</button>
        </form>
        <?php if (isset($_SESSION['user']['level'])) : ?>
          <?php if ($_SESSION['user']['level'] == 'admin') : ?>
            <a href="cetak_pengaduan.php" class="btn btn-outline-primary">Cetak</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <?php if (empty($data_pengaduan)) : ?>
        <h3 style="font-weight: 600; color: var(--primary-color); margin-top: 20px;">Data tidak ditemukan</h3>
      <?php else : ?>
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Isi Laporan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_pengaduan as $key => $data) : ?>
              <tr>
                <td><?= ++$key; ?>.</td>
                <td>
                  <img width="100" src="./images/<?= $data['foto']; ?>" alt="image">
                </td>
                <td><?= $data['status'] == 'proses' ? "Menunggu" : "Selesai"; ?></td>
                <td>
                  <?= substr($data['isi_laporan'], 0, 150); ?>
                </td>
                <td>
                  <?php if (isset($_SESSION['user']['level'])) : ?>
                    <form method="POST">
                      <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan']; ?>">
                      <button type="submit" name="hapus_pengaduan" class=" btn btn-outline-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus?');">Hapus</button>
                    </form>
                    <a href="tanggapan.php?id_pengaduan=<?= $data['id_pengaduan'] ?>" class="btn btn-outline-primary">Tanggap</a>
                  <?php endif; ?>
                  <a href="detail_pengaduan.php?id_pengaduan=<?= $data['id_pengaduan'] ?>" class="btn btn-primary">Lihat</a>
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
    const isiPengaduanBtn = document.querySelector(".btn-isi-pengaduan");
    const pengaduanCard = document.querySelector(".pengaduan-card");
    isiPengaduanBtn.addEventListener("click", () => pengaduanCard.classList.toggle("hidden"));
  </script>
</body>

</html>