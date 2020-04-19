<?php
class GoogleOauth
{
  private $google_client;
  // SetPengaturan($client_id string, $secret_key string, $url_tujuan string)
  // Untuk mengatur pengaturan google oauth
  // @Param :
  // $client_id : ID client dari google oauth yang bisa didapatkan dari akun google developer
  // $secret_key : Private client key yang bisa didapatkan dari akun google developer
  // $url_tujuan : Setelah proses login dengan google selesai, maka user akan diarahkan ke $url_tujuan, dengan membaca query string ?code=TOKEN_GOOGLE_OAUTH
  public function SetPengaturan($client_id, $secret_key, $url_tujuan)
  {
    // BAGIAN PENGATURAN GOOGLE OAUTH
    // KODE PENGATURAN INI WAJIB ADA UNTUK MENGGENERATE LINK LOGIN GOOGLE AUTH
    // ATAU UNTUK MEMPROSES TOKEN LOGIN GOOGLE AUTH
    $this->google_client = new Google_Client();
    $this->google_client->setClientId($client_id);
    $this->google_client->setClientSecret($secret_key);
    // USER AKAN DIRAHKAN KEHALAMANA DIBAWAH SAAT AUTENTIKASI SELESAI, DENGAN MEMBAWA ?code=TOKENNYA
    $this->google_client->setRedirectUri('http://google.dafma.id/index.php');
    $this->google_client->addScope('email');
    $this->google_client->addScope('profile');
    // PENUTUP BAGIAN PENGATURAN
  }
  
  // GetDatauser($token string) Array
  // Untuk mengambil data user seperti email, foto profil dll dari token hasil login google oauth oleh user
  // @Param :
  // $token : token yang dihasilkan dari proses login user dengan akun google dari google oauth
  // @Return :
  // Array assosiatif 
  // $return['error'] boolean : untuk mengetahui apakan tokennya error atau tidak, true jika error
  // $return['messsage'] string : pesan error dari token error tsb
  // $return['data'] Array : data user yang didapat dari token jika tidak ada error pada token
  public function GetDataUser($token)
  {
      $data = [
        "error" => true,
        "message" => "Token tidak valid",
        "data" => null
      ];
      // proses pengecekan token
     $token = $this->google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
     // proses pengecekan error token
     if(!isset($token['error']))
     {
      // set token dari token yang sudah dicek
      // token yang sudah dicek akan disimpan di variabel $token['access_token']
      $this->google_client->setAccessToken($token['access_token']);
      // buat object google oauth client
      $this->google_service = new Google_Service_Oauth2($google_client);
      // ambil data user dari token
      // VARIABEL DATA AKAN BERISI DATA PROFIL USER
      // VARIABEL DATA BERUPA ARRAY ASSOSIATIF
      $data['error'] = false;
      $data['message'] = "Ok";
      $data['data'] = $this->google_service->userinfo->get();
    }
    return $data;
  }
  
  // GetLinkLogin
  // @Return : string
  // $return menghasilkan string yang berisi link untuk login google oauth
  // link ini bisa disematkan pada tag HTML <a>
  public function GetLinkLogin()
  {
    return $this->google_client->createAuthUrl();
  }
}
?>
