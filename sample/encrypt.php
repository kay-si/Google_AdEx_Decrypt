<?php
function urlsafe_b64encode($string)
{
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}
echo urlsafe_b64encode(implode( array( 
"\xb0","\x8c","\x70","\xcf","\xbc",
"\xb0","\xeb","\x6c","\xab","\x7e",
"\x82","\xc6","\xb7","\x5d","\xa5",
"\x20","\x72","\xae","\x62","\xb2",
"\xbf","\x4b","\x99","\x0b","\xb8",
"\x0a","\x48","\xd8","\x14","\x1e",
"\xec","\x07"
) ) ) . "\n";
echo urlsafe_b64encode(implode( array(     
"\xbf","\x77","\xec","\x55","\xc3",
"\x01","\x30","\xc1","\xd8","\xcd",
"\x18","\x62","\xed","\x2a","\x4c",
"\xd2","\xc7","\x6a","\xc3","\x3b",
"\xc0","\xc4","\xce","\x8a","\x3d",
"\x3b","\xbd","\x3a","\xd5","\x68",
"\x77","\x92"
) ) ) . "\n";
