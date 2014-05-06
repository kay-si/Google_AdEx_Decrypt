# import system files
import sys,os
import binascii

# get requirement files
dirname   = os.path.abspath(os.path.dirname(__file__)) 
dirsep    = os.sep
sys.path.append(  os.sep.join( [ os.path.dirname(os.path.abspath(__file__)) , '..', 'lib' ] ) )
from DecryptIdfa import DecryptIdfa

encryption_encoded_key  = "AAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8,";
integrity_encoded_key   = "Hx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQA,";
long_ciphertext         = {
  "encrypted_hashed_idfa"    : binascii.unhexlify( "51928A6600000000AAAAAACEAAAAAACEB30EDBA1D938ACFB12C91670AB8D01F31E434557" ),
  "encrypted_advertising_id" : binascii.unhexlify( "51928A6600000000AAAAAACEAAAAAACED2C32DF16B1658B8447591BE4BA853922C55ABAD" )
};
decrypt_idfa = DecryptIdfa( encryption_encoded_key, integrity_encoded_key );
idfa_set = decrypt_idfa.decryption( long_ciphertext["encrypted_hashed_idfa"]  );
print {
    "idfa_hex" : binascii.hexlify( idfa_set["idfa"]),
    "datetime" : idfa_set["datetime"],
};
idfa_set = decrypt_idfa.decryption( long_ciphertext["encrypted_hashed_idfa"]  );
print {
    "idfa_hex" : binascii.hexlify( idfa_set["idfa"] ),
    "datetime" : idfa_set["datetime"],
};
