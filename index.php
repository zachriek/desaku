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

  <section id="beranda">
    <div class="container">
      <h1 class="title">Website Pelaporan Pengaduan Masyarakat</h1>
      <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet ipsum veritatis eius. Pariatur aperiam consectetur at itaque fugit veniam libero.</p>
      <a class="btn btn-primary" href="pengaduan.php">Mulai Sekarang</a>
    </div>
  </section>

  <?php include "./components/footer.php"; ?>
</body>

</html>