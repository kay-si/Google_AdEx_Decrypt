# import system files
import sys,os
import binascii

# get requirement files
dirname   = os.path.abspath(os.path.dirname(__file__)) 
dirsep    = os.sep
sys.path.append(  os.sep.join( [ os.path.dirname(os.path.abspath(__file__)) , '..', 'lib' ] ) )
from DecryptHyperLocal import DecryptHyperLocal
from DecryptIdfa import DecryptIdfa

encryption_encoded_key  = "Au6oPGwSEeELn4iWbO7DSQjrlG9-1uRBr0KzwPMhgUA.";
integrity_encoded_key   = "v__sVcMBMMHYzRhi7SpM0sdqwzvAxM6KPTu9OtVod5I.";
long_ciphertext         = binascii.unhexlify( "E2014EA201246E6F6E636520736F7572636501414243C0ADF6B9B6AC17DA218FB50331EDB376701309CAAA01246E6F6E636520736F7572636501414243C09ED4ECF2DB7143A9341FDEFD125D96844E25C3C202466E6F6E636520736F7572636502414243517C16BAFADCFAB841DE3A8C617B2F20A1FB7F9EA3A3600256D68151C093C793B0116DB3D0B8BE9709304134EC9235A026844F276797" );

DecryptHyperLocal = DecryptHyperLocal( encryption_encoded_key, integrity_encoded_key );
bid_request       = DecryptHyperLocal.deserialize_bid_request( long_ciphertext );
print DecryptHyperLocal.decryption( bid_request.encrypted_hyperlocal_set );
decrypt_idfa = DecryptIdfa( encryption_encoded_key, integrity_encoded_key );
idfa_set = decrypt_idfa.decryption( bid_request.mobile.encrypted_hashed_idfa  );
print {
    "idfa_hex" : binascii.hexlify( idfa_set["idfa"]),
    "datetime" : idfa_set["datetime"],
};
idfa_set = decrypt_idfa.decryption( bid_request.mobile.encrypted_advertising_id  );
print {
    "idfa_hex" : binascii.hexlify( idfa_set["idfa"] ),
    "datetime" : idfa_set["datetime"],
};
