Google_Decrypter
================

## Prepare ( if hyperlocal use decrpytion )

### Install Protocol Buffer

Download from Google

https://code.google.com/p/protobuf/

```
mkdir ~/src && cd ~/src
curl -o protobuf-2.5.0.tar.bz https://protobuf.googlecode.com/files/protobuf-2.5.0.tar.bz
tar -xzf protobuf-2.5.0.tar.gz
cd protobuf-2.5.0
./configure
make
sudo make install
```

### Install php-protocolbuffers

```
cd ~/src
git clone https://github.com/chobie/php-protocolbuffers.git
cd php-protocolbuffers
phpize
./configure
make
make test
sudo make install
```

### Add php.ini

```
extension=protocolbuffers.so
```

### Initialize 

```
./init.sh
```

## How to use

```$encryption_encoded_key``` and ```$integrity_encoded_key``` is encrypted by urlsafe_b64encode.

```$long_ciphertext``` is binary data. 
Please check sample directory

### Decrypt Price
```
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptPrice.php";
$DecryptPrice = new DecryptPrice( $encryption_encoded_key, $integrity_encoded_key );
$decrypt_data = $DecryptPrice-> decrypt( $long_ciphertext );
```

### Decrypt Hyper Local
```
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
```

### Decrypt IDFA
```
require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "DecryptHyperLocal.php";
date_default_timezone_set( "Asia/Tokyo");
$DecryptHyperLocal = new DecryptHyperLocal( $encryption_encoded_key, $integrity_encoded_key );
var_dump( $DecryptHyperLocal -> decrypt( $long_ciphertext ) );
```
