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

#### Ver php

##### Install php-protocolbuffers

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

##### Add php.ini

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
