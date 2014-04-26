<?php
function urlsafe_b64decode($string)
{
  $data = str_replace(array('-','_','.'),array('+','/','='),$string);
  $mod4 = strlen($data) % 4;
  if ($mod4) {
    $data .= substr('====', $mod4);
  }
  return base64_decode($data);
}


$encryption_encoded_key = "sIxwz7yw62yrfoLGt12lIHKuYrK_S5kLuApI2BQe7Ac";
$integrity_encoded_key  = "v3fsVcMBMMHYzRhi7SpM0sdqwzvAxM6KPTu9OtVod5I";
$long_ciphertext = "SjpvRwAB4kB7jEpgW5IA8p73ew9ic6VZpFsPnA";

$long_ciphertext =  urlsafe_b64decode($long_ciphertext);
var_dump( strlen( $long_ciphertext ) );
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptPrice.php";
date_default_timezone_set( "Asia/Tokyo");
$DecryptPrice = new DecryptPrice( $encryption_encoded_key, $integrity_encoded_key );
var_dump( $DecryptPrice-> decrypt( $long_ciphertext ) );
