<?php
$encryption_encoded_key  = "Au6oPGwSEeELn4iWbO7DSQjrlG9-1uRBr0KzwPMhgUA.";
$integrity_encoded_key   = "v__sVcMBMMHYzRhi7SpM0sdqwzvAxM6KPTu9OtVod5I.";
$long_ciphertext         = hex2bin( "E2014EA201246E6F6E636520736F7572636501414243C0ADF6B9B6AC17DA218FB50331EDB376701309CAAA01246E6F6E636520736F7572636501414243C09ED4ECF2DB7143A9341FDEFD125D96844E25C3C202466E6F6E636520736F7572636502414243517C16BAFADCFAB841DE3A8C617B2F20A1FB7F9EA3A3600256D68151C093C793B0116DB3D0B8BE9709304134EC9235A026844F276797" );

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptHyperLocal.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptIdfa.php";
date_default_timezone_set( "Asia/Tokyo");
$DecryptHyperLocal = new DecryptHyperLocal( $encryption_encoded_key, $integrity_encoded_key );
$bid_request       = $DecryptHyperLocal->deserialize_bid_request( $long_ciphertext );
var_dump( $DecryptHyperLocal -> decrypt( $bid_request["\0*\0encrypted_hyperlocal_set"] ) );
$DecryptIdfa = new DecryptIdfa( $encryption_encoded_key, $integrity_encoded_key );
$mobile_data = (array)$bid_request["\0*\0mobile"];
$idfa_set = $DecryptIdfa -> decrpyt( $mobile_data["\0*\0encrypted_advertising_id"]  );
var_dump( array(
    "idfa_hex" => bin2hex( $idfa_set["idfa"] ),
    "datetime" => $idfa_set["datetime"],
));
$idfa_set = $DecryptIdfa -> decrpyt( $mobile_data["\0*\0encrypted_hashed_idfa"]  );
var_dump( array(
    "idfa_hex" => bin2hex( $idfa_set["idfa"] ),
    "datetime" => $idfa_set["datetime"],
));
