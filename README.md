Google_Decrypter
================

# Prepare

## Install Protocol Buffer

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

## Install php-protocolbuffers

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

## Add php.ini

```
```
