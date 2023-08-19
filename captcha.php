<?php
$captcha_code = md5(rand());
$captcha_code = substr($captcha_code, 0, 4);
$_SESSION['captcha_code'] = $captcha_code;

?>

<div class="captcha_code">
  <?= $_SESSION['captcha_code']; ?>
</div>