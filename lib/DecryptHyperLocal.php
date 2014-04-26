<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . "Decrypt.php" );
class DecryptHyperLocal extends Decrypt{
   function __construct($encryption_encoded_key, $integrity_encoded_key){
      $iv_length   = 16;
      $is_length   = 4; 
      $byte_length = 20;
      parent::__construct( $encryption_encoded_key, $integrity_encoded_key, $iv_length, $is_length, $byte_length );
   }
   function decrypt($long_ciphertext){
      $res = parent::run( $long_ciphertext );
       if(isset( $res['error']) ){
           return $res;
       }else{
           return array(
              'hyperlocal' => self::decrypt_hyper_local( $res["plaintext"] ),
              'datetime'   => $res["datetime"],
           );
       }
   }
   private function decrypt_hyper_local( $plaintext ){
      $hyper_local_set = ProtocolBuffers::decode( "HyperlocalSet", $plaintext );
      list( $hyper_local, $center_point ) = array_values( (array)$hyper_local_set );
      return array(
         'corners'        => self::get_corners( array_values( (array) $hyper_local[0] ) ),
         "center_point"   => self::get_lat_long((array)$center_point ),
      );
   }
   private function get_corners( $hyper_local_set ){
      $res = array();
      $corners = array_values( $hyper_local_set  )[0];
      foreach( $corners as $corner ){
         array_push( $res,  self::get_lat_long( (array)$corner ) );
      }
      return $res;
   }

   private function get_lat_long( $point ){
       list( $lat, $long ) = array_values( $point );
       return array(
          'lat' => $lat,
          'long' => $long
       );
   }
}
?>
