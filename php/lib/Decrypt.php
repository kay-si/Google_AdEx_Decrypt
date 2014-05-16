<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "realtimebidding" . DIRECTORY_SEPARATOR . "autoload.php";
class Decrypt{

    function __construct( $encryption_encoded_key, $integrity_encoded_key, $iv_length, $is_length, $byte_length ){
        $this->encryption_key = self::urlsafe_b64decode( $encryption_encoded_key );
        $this->integrity_key  = self::urlsafe_b64decode( $integrity_encoded_key );
        $this->iv_length   = $iv_length;
        $this->is_length   = $is_length;
        $this->byte_length = $byte_length;
    }

    function run( $long_ciphertext ){
        list( $initialization_vector, $ciphertext, $integrity_signature ) = self::parse_long_ciphertext( $long_ciphertext );
        $plaintext = self::get_plaintext( $ciphertext, $initialization_vector );
        if( self::check_signature( $plaintext, $initialization_vector, $integrity_signature)  ){
             return array( 
                  "plaintext" => $plaintext,
                  "datetime"  => self::get_date( $initialization_vector ),
             );
        }else{
             return array( "error" => "Wrong Decription" );
        }
    }
    public function deserialize_bid_request( $serialized_protocol_buffer ){
       return (array)( ProtocolBuffers::decode( "BidRequest", $serialized_protocol_buffer ) );
    }
    private function parse_long_ciphertext( $long_ciphertext ){
        $initialization_vector = substr($long_ciphertext, 0,  $this->iv_length);
        $ciphertext            = substr($long_ciphertext,      $this->iv_length, -$this->is_length );
        $integrity_signature   = substr($long_ciphertext,     -$this->is_length);
        return array( $initialization_vector, $ciphertext, $integrity_signature );
    }

    private function get_plaintext( $ciphertext, $iv ){
        $plaintext = array();
        $add_iv_counter_byte = true;
        for( $n = 0;  strlen( $ciphertext ) > $n * $this->byte_length; $n++){
             $data        = substr( $ciphertext , $n * $this->byte_length, $this->byte_length );
             $hmacer      = hash_init('sha1', true, $this->encryption_key );
             hash_update( $hmacer, $iv );
             $pad         = hash_final( $hmacer, true );
             $byte_array  = unpack("c*", $data);
             $pad         = unpack("c*", $pad );
             foreach( $byte_array as $key => $val ){
                 $plaintext[] = pack( "C*", $val ^ $pad[$key] );
             }

             if (!$add_iv_counter_byte) {
                if( $n % 256 == 0 ){
                    $add_iv_counter_byte =  true;
                }
                $iv = self::add_initialization_vector( $iv );
             }

             if ($add_iv_counter_byte) {
                $add_iv_counter_byte = false;
                $iv .= "\x00";
             }
        }
        return implode( $plaintext );
   }

   private function check_signature( $plaintext, $initialization_vector, $integrity_signature){
        $hmacer = hash_init('sha1', true, $this->integrity_key );
        hash_update( $hmacer, $plaintext );
        hash_update( $hmacer, $initialization_vector );
        $Signature =  hash_final( $hmacer, true );
        $computedSignature = substr( $Signature, 0, $this->is_length );
        return $computedSignature == $integrity_signature;
   }

   private function add_initialization_vector( $iv ){
         $arr = unpack("c*" ,$iv);
         $res = array();
         foreach( $arr as $key => $value ){
            if( count($arr) == $key ){
                $value++;
            }
            array_push( $res,  pack("c*", $value ));
         }
         return implode($res );
   }

   private function get_date( $iv ){ 
         $sec    = unpack( "N*" ,substr( $iv, 0, 4 ) );
         $usec  = unpack( "N*" ,substr( $iv, 4, 4 ) );
         $timestamp = ( implode( $sec ) + implode( $usec ) / 1000 );
         return date( "Y/m/d H:i:s", $timestamp );
   }

   private function urlsafe_b64decode($string)
   {
      $data = str_replace(array('-','_','.'),array('+','/','='),$string);
      $mod4 = strlen($data) % 4;
      if ($mod4) {
         $data .= substr('====', $mod4);
      }
      return base64_decode($data);
   }
}
?>
