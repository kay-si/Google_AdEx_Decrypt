# import system files
import sys,os
import binascii
import base64

# get requirement files
dirname   = os.path.abspath(os.path.dirname(__file__)) 
dirsep    = os.sep
sys.path.append(  os.sep.join( [ os.path.dirname(os.path.abspath(__file__)) , '..', 'lib' ] ) )
from DecryptPrice import DecryptPrice

def _urlsafe_b64decode( s ):
    return base64.urlsafe_b64decode(s + '=' * (4 - len(s) % 4))

encryption_encoded_key = "sIxwz7yw62yrfoLGt12lIHKuYrK_S5kLuApI2BQe7Ac";
integrity_encoded_key  = "v3fsVcMBMMHYzRhi7SpM0sdqwzvAxM6KPTu9OtVod5I";
long_ciphertext = "SjpvRwAB4kB7jEpgW5IA8p73ew9ic6VZpFsPnA";

long_ciphertext =  _urlsafe_b64decode(long_ciphertext);

decrypt_price = DecryptPrice( encryption_encoded_key, integrity_encoded_key );
print decrypt_price.decryption( long_ciphertext );
