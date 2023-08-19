<header>
  <nav class="navbar container">
    <a href="index.php" class="navbar-brand">Desaku</a>
    <ul class="nav-menu">
      <li class="nav-item">
        <a href="index.php" class="nav-link">Beranda</a>
      </li>
      <li class="nav-item">
        <a href="pengaduan.php" class="nav-link">Pengaduan</a>
      </li>
      <?php if (isset($_SESSION['user']['level'])) : ?>
        <?php if ($_SESSION['user']['level'] == 'admin') : ?>
          <li class="nav-item">
            <a href="masyarakat.php" class="nav-link">Masyarakat</a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      <li class="nav-item logout-btn">
        <a href="logout.php" class="nav-link" onclick="return confirm('Apakah kamu yakin ingin keluar?');">Logout</a>
      </li>
    </ul>
  </nav>
</header>