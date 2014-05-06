<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . "Decrypt.php" );
class DecryptPrice extends Decrypt{
   function __construct($encryption_encoded_key, $integrity_encoded_key){
      $iv_length = 16;
      $is_length = 4; 
      $byte_length = 8;
      parent::__construct( $encryption_encoded_key, $integrity_encoded_key, $iv_length, $is_length, $byte_length );
   }
   function decrypt($long_ciphertext){
      $res = parent::run( $long_ciphertext );
       if(isset( $res['error']) ){
           return $res;
       }else{
           $price = unpack("N*", $res["plaintext"]);
           return array(
              'price'      => $price[2],
              'datetime'   => $res["datetime"],
           );
       }
   }
}
?>
