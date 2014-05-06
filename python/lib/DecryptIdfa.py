import sys,os
from Decryption import Decryption
class DecryptIdfa(Decryption):
    def __init__( self, encryption_encoded_key, integrity_encoded_key):
        iv_length = 16;
        is_length = 4; 
        byte_length = 16;
        self.decrypt = Decryption.__init__( self, encryption_encoded_key, integrity_encoded_key, iv_length, is_length, byte_length );
    def decryption( self, long_ciphertext ):
        res = Decryption.run( self, long_ciphertext );
        if "error" in res:
            return res;
        else:
            return {
                'idfa'     : res["plaintext"],
                'datetime' : res["datetime"],
            };
