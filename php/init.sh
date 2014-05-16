curl -s http://getcomposer.org/installer | php
php composer.phar install
mkdir RealtimeBidding
protoc protocolbuf/realtime-bidding.proto --plugin=vendor/bin/protoc-gen-php --php_out=RealtimeBidding
mkdir HyperLocal
protoc protocolbuf/hyperlocal.proto --plugin=vendor/bin/protoc-gen-php --php_out=HyperLocal 
