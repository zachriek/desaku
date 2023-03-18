<?php

include "koneksi.php";

session_start();

if (isset($_SESSION['user'])) {
  header("Location: index.php");
}

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $user = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password'");
  if ($user->num_rows > 0) {
    $data_user = mysqli_fetch_array($user);
    $_SESSION['user'] = $data_user;

    echo "<script>alert('Berhasil masuk!'); window.location.href = 'login.php';</script>";
  } else {
    echo "<script>alert('Gagal masuk!');";
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
              <input type="text" class="form-input" name="username" placeholder="Masukkan Username">
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-input" name="password" placeholder="Masukkan Password">
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