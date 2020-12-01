<?php

require __DIR__ . "/../vendor/autoload.php";

use \Firebase\JWT\JWT;

class Token
{

  public static function GenerarToken($email)
  {
    $payload = array(
      "iss" => "http://example.org",
      "aud" => "http://example.com",
      "iat" => 1356999524,
      "nbf" => 1357000000,
      "email" => $email,
    );
    return JWT::encode($payload, "primerparcial");
  }

  public static function leerToken($token)
  {
    try {
      $decode = JWT::decode($token, "primerparcial", array('HS256'));
      return  $decode;
    } catch (\Throwable $th) {
      return false;
    }
  }
  static function autenticarToken($token,$ok, $fail)
  {
    if (Token::leerToken($token) == false) {
      echo $fail;
      return false;
    } else {
      echo $ok;
      return true;
    }
  }


}
