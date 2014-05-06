curl -s http://getcomposer.org/installer | php
php composer.phar install
mkdir HyperLocal
protoc protocolbuf/hyperlocal.proto --plugin=vendor/bin/protoc-gen-php --php_out=HyperLocal 
