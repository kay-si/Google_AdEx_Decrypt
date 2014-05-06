<?php
date_default_timezone_set( "Asia/Tokyo");
$encryption_encoded_key  = "AAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8,";
$integrity_encoded_key   = "Hx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQA,";
$long_ciphertext         = array(
  "encrypted_hashed_idfa" => hex2bin( "51928A6600000000AAAAAACEAAAAAACEB30EDBA1D938ACFB12C91670AB8D01F31E434557" ),
  "encrypted_advertising_id" => hex2bin( "51928A6600000000AAAAAACEAAAAAACED2C32DF16B1658B8447591BE4BA853922C55ABAD" )
);
 
require_once __DIR__ . DIRECTORY_SEPARATOR . "../" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptIdfa.php";
$DecryptIdfa = new DecryptIdfa( $encryption_encoded_key, $integrity_encoded_key );
$idfa_set = $DecryptIdfa -> decrpyt( $long_ciphertext["encrypted_hashed_idfa"]  );
var_dump( array(
    "idfa_hex" => bin2hex( $idfa_set["idfa"] ),
    "datetime" => $idfa_set["datetime"],
));
$idfa_set = $DecryptIdfa -> decrpyt( $long_ciphertext["encrypted_hashed_idfa"]  );
var_dump( array(
    "idfa_hex" => bin2hex( $idfa_set["idfa"] ),
    "datetime" => $idfa_set["datetime"],
));
