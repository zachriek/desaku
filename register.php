<?php

include "koneksi.php";

session_start();

if (isset($_SESSION['user'])) {
  header("Location: index.php");
}

if (isset($_POST['registrasi'])) {
  $nik =  htmlspecialchars($_POST['nik']);
  $nama = htmlspecialchars($_POST['nama']);
  $username = htmlspecialchars($_POST['username']);
  $password = md5(htmlspecialchars($_POST['password']));
  $telp = htmlspecialchars($_POST['telp']);

  $user = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik' AND username='$username'");

  if ($user->num_rows > 0) {
    echo "<script>alert('User sudah terdaftar!');</script>";
  } else {
    $query = mysqli_query($conn, "INSERT INTO `masyarakat`(`id`, `nik`, `nama`, `username`, `password`, `telp`) VALUES ('','$nik','$nama','$username','$password','$telp')");

    if ($query) {
      echo "<script>alert('Berhasil daftar!'); window.location.href = 'login.php';</script>";
    } else {
      echo "<script>alert('Gagal daftar!');</script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi</title>
  <link rel="stylesheet" href="./css/global.css">
  <link rel="stylesheet" href="./css/auth.css">
</head>

<body>
  <section class="auth">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h2 class="card-heading">Registrasi</h2>
          <form class="form" method="POST">
            <div class="form-group">
              <label class="form-label" for="nik">NIK</label>
              <input type="text" class="form-input" name="nik" placeholder="Masukkan NIK" autofocus required>
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
            <div class="btn-group">
              <button type="submit" name="registrasi" class=" btn btn-primary">Daftar</button>
              <a href="login.php" class="link">Masuk</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>

</html>