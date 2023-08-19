<?php

include "koneksi.php";

session_start();

if (isset($_SESSION['user'])) {
  header("Location: index.php");
}

if (isset($_POST['login'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = md5(htmlspecialchars($_POST['password']));
  $captcha = $_POST['captcha'];

  if ($captcha != $_SESSION['captcha_code']) {
    echo "<script>alert('Kode captcha tidak sesuai!'); window.location.href = 'login.php';</script>";
    exit;
  }

  $cek_petugas = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
  $cek_masyarakat = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'");

  if ($cek_petugas->num_rows > 0 && $cek_masyarakat->num_rows > 0) {
    echo "<script>alert('Username sudah terdaftar!'); window.location.href = 'login.php';</script>";
  }

  $user = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password'");

  if ($user->num_rows > 0) {
    $data_user = mysqli_fetch_array($user);
    $_SESSION['user'] = $data_user;

    echo "<script>alert('Berhasil masuk!'); window.location.href = 'index.php';</script>";
  } else {
    $petugas = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");

    if ($petugas->num_rows > 0) {
      $data_petugas = mysqli_fetch_array($petugas);
      $_SESSION['user'] = $data_petugas;

      echo "<script>alert('Berhasil masuk!'); window.location.href = 'index.php';</script>";
    } else {
      echo "<script>alert('Gagal masuk!'); window.location.href = 'login.php';</script>;";
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
  <title>Login</title>
  <link rel="stylesheet" href="./css/global.css">
  <link rel="stylesheet" href="./css/auth.css">
</head>

<body>
  <section class="auth">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h2 class="card-heading">Login</h2>
          <form class="form" method="POST">
            <div class="form-group">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-input" name="username" placeholder="Masukkan Username" autofocus required>
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-input" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="form-group">
              <?php include "captcha.php"; ?>
              <label for="captcha" class="form-label">Kode Captcha</label>
              <input type="text" class="form-input" name="captcha" placeholder="Masukkan Kode Captcha" required>
            </div>
            <div class="btn-group">
              <button type="submit" name="login" class=" btn btn-primary">Masuk</button>
              <a href="register.php" class="link">Registrasi</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>

</html>