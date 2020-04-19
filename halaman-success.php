<?php
  require "vendor/autoload.php";
  require_once "google-oauth.php"; // file ini berisi kode google oauth yang sudah diringkas
  // informasi seperti username, email, foto dll akan dimunculkan di halaman-success.php
  $google = new GoogleOauth("CLIEN_ID_ANDA", "PRIVATE_KEY", "http://domainkamu.com/halaman-success.php");
  
  // Token akan otomatis berada di query string code, yang berasal dari halaman-login.php :
  if(!empty($_GET['code']))
  {
    // token yang sudah ada, akan diambil datanya
    $data = $google->GetDataUser($_GET['code']);
    
    // kita cek dulu apaka token valid atau tidak
    if($data['error'] == true)
    {
      // munculkan error jika ada error
      echo $data['message'];
    }
    else
    {
      // jika tidak error, tampilkan data user dalam bentuk json
      // data user tersimpan di variabel $data['data'] dalam bentuk array asosiatif
      echo json_encode($data['data']);
    }
  }
?>
