import sys,os
dirname   = os.path.abspath(os.path.dirname(__file__)) 
dirsep    = os.sep
sys.path.append(  os.sep.join( [ os.path.dirname(os.path.abspath(__file__)) , '..', 'Hyperlocal', 'protocolbuf'] ) )
import hyperlocal_pb2
from Decryption import Decryption
class DecryptHyperLocal( Decryption ):
    def __init__( self, encryption_encoded_key, integrity_encoded_key):
        iv_length   = 16;
        is_length   = 4; 
        byte_length = 20;
        self.decrypt = Decryption.__init__( self, encryption_encoded_key, integrity_encoded_key, iv_length, is_length, byte_length );

    def decryption(self, long_ciphertext):
        res = Decryption.run( self, long_ciphertext );
        if "error" in res:
            return res;
        else:
            return {
                'hyperlocal': self.decrypt_hyper_local( res["plaintext"] ),
                'datetime'  : res["datetime"],
            };

    def decrypt_hyper_local( self, plaintext ):
        hyper_local_set = hyperlocal_pb2.HyperlocalSet();
        hyper_local_set.ParseFromString( plaintext );
        return {
            'corners'       : self.get_corners( hyper_local_set.hyperlocal ),
            "center_point"  : self.get_lat_long( hyper_local_set.center_point ),
        };

    def get_corners( self, hyper_local_set ):
        res = [];
        for corner in hyper_local_set[0].corners:
            res.append( self.get_lat_long( corner ) );
        return res;
 
    def get_lat_long( self, point ):
        return {
            'lat' : point.latitude,
            'long' : point.longitude
        };
