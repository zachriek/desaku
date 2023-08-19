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

$query = mysqli_query($conn, "SELECT * FROM pengaduan");

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
  <section id="cetak">
    <div class="container">
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Foto</th>
            <th>Status</th>
            <th>Isi Laporan</th>
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
                <?= $data['isi_laporan']; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <script>
    window.print();
    window.addEventListener('afterprint', () => window.location.href = 'pengaduan.php');
  </script>
</body>

</html>