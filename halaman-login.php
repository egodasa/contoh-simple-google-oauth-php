<?php
  require "vendor/autoload.php";
  require_once "google-oauth.php"; // file ini berisi kode google oauth yang sudah diringkas
  // informasi seperti username, email, foto dll akan dimunculkan di halaman-success.php
  $google = new GoogleOauth("CLIEN_ID_ANDA", "PRIVATE_KEY", "halaman-success.php");
  $link = $google->GetLinkLogin();
?>

<html>
  <head>
    <title>Login Dengan Google Oauth</title>
  </head>
  <body style="margin: 0 auto;text-align: center;">
    <div style="padding-top: 30px;">
      <h2>Silahkan tekan tombol dibawah ini</h2>
      <a href="<?=$link?>"><img src="button.png" width="250" alt="Tombol Login Dengan Google Klik Disini" /></a>
      <h3>Setelah Anda login dengan mengklik tombol diatas, maka Anda akan diarahkan ke <br>
      halaman-success.php?code=TOKEN_YANG_TERGENERATE_SENDIRI
      <br>
      Dan di halaman-success.php, Anda bisa menampilkan data user yang login
      </h3>
    </div>
  </body>
</html>
