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

$query = mysqli_query($conn, "SELECT * FROM masyarakat");

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
  <section id="cetak">
    <div class="container">
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Telp</th>
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
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <script>
    window.print();
    window.addEventListener('afterprint', () => window.location.href = 'masyarakat.php');
  </script>
</body>

</html>