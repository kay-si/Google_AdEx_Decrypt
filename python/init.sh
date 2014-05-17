pip install protobuf
mkdir RealtimeBidding
protoc protocolbuf/realtime-bidding.proto --python_out=RealtimeBidding
mkdir HyperLocal
protoc protocolbuf/hyperlocal.proto --python_out=HyperLocal 
