import base64
import sha
import hmac
import binascii
import time
import datetime
from struct import *
from hashlib import sha1
import sys,os
dirname   = os.path.abspath(os.path.dirname(__file__)) 
dirsep    = os.sep
sys.path.append(  os.sep.join( [ os.path.dirname(os.path.abspath(__file__)) , '..', 'Realtimebidding', 'protocolbuf' ] ) )
import realtime_bidding_pb2
class Decryption:
    def __init__( self, encryption_encoded_key, integrity_encoded_key, iv_length, is_length, byte_length ) :
        self.encryption_key = self._urlsafe_b64decode( encryption_encoded_key );
        self.integrity_key  = self._urlsafe_b64decode( integrity_encoded_key );
        self.iv_length   = iv_length;
        self.is_length   = is_length;
        self.byte_length = byte_length;

    def run( self, long_ciphertext ):
        initialization_vector, ciphertext, integrity_signature = self._parse_long_ciphertext( long_ciphertext );
        plaintext = self._get_plaintext( ciphertext, initialization_vector );
        if( self._check_signature( plaintext, initialization_vector, integrity_signature)  ) :
            return { 
                "plaintext" : plaintext,
                "datetime"  : self._get_date( initialization_vector )
                }
        else :
           return { "error" : "Wrong Decription" };
 
    def deserialize_bid_request( self, serialized_protocol_buffer ):
        bid_request = realtime_bidding_pb2.BidRequest();
        bid_request.ParseFromString( serialized_protocol_buffer ) ;
        return ( bid_request );

    def _parse_long_ciphertext( self, long_ciphertext ):
        initialization_vector = long_ciphertext[ 0:  self.iv_length];
        ciphertext            = long_ciphertext[ self.iv_length: -self.is_length ];
        integrity_signature   = long_ciphertext[-self.is_length:];
        return [ initialization_vector, ciphertext, integrity_signature ]; 
 
    def _get_plaintext( self, ciphertext, iv ):
        plaintext = [];
        add_iv_counter_byte = True;
        n = 0;
        while( len( ciphertext ) > n * self.byte_length ):
            data  = ciphertext[ n * self.byte_length: (n+1)*self.byte_length ];
            pad = hmac.new( self.encryption_key, iv , sha1).hexdigest()
            pad = binascii.unhexlify(pad );         
            byte_array = unpack( str(len(data)) + "B", data);
            pad        = unpack("20B", pad );
            for key in range(len(byte_array)) :
                plaintext.append( chr( byte_array[key] ^ pad[key] ) );
 
            if add_iv_counter_byte == False :
                if( n % 256 == 0 ):
                    add_iv_counter_byte =  True;
                iv = self._add_initialization_vector( iv );
 
            if (add_iv_counter_byte) :
                add_iv_counter_byte = False;
                iv += "\x00";
            n += 1
        return "".join( plaintext );
 
    def _check_signature( self, plaintext, initialization_vector, integrity_signature):
        hex_signature = hmac.new( self.integrity_key, plaintext + initialization_vector, sha1).hexdigest() 
        Signature     = binascii.unhexlify( hex_signature );
        computedSignature = Signature[ 0 : self.is_length ];
        return computedSignature == integrity_signature;
 
    def _add_initialization_vector( self, iv ):
        arr = unpack( str( len(iv) ) + "c" ,iv);
        res = [];
        for key in range(len(arr)) :
            value = arr[key]
            if( len(arr) - 1 == key ):
                bin_value = pack( "h",int( binascii.hexlify( value ) ) + 1 );
                value     = unpack( str(len(bin_value)) + "c", bin_value )[0]; 
            res.append( pack("c", value ));
        return ''.join(res);
 
    def _get_date( self, iv ):
        sec   = unpack( ">i" , iv[ 0: 4 ] );
        usec  = unpack( ">i" , iv[ 4: 8 ] );
        timestamp = ( sec[0] + usec[0] / 1000 );
        return datetime.datetime.fromtimestamp(timestamp).strftime("%Y/%m/%d %H:%M:%S");

    def _urlsafe_b64decode( self, s ):
        return base64.urlsafe_b64decode(s + '=' * (4 - len(s) % 4))
