<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function Decryption()
    {
        return view('decryption');
    }

    public function EncryptPhoto(Request $request)
    {
        $request->validate([
            'image'=>'required|mimes:png,jpg,jpeg,bmp',
            'encrypt_key'=>'required'
        ]);

        $image_bytes = base64_encode(file_get_contents($request->file('image')->path()));//convert image to bytes
        $encrypted_image = $this->DataEncryption($image_bytes, $request->input('encrypt_key'));//encrypt the image bytes
        $filelocation  = ('C:\\Windows\Temp\\'.'encrypted.txt');
        $file = fopen($filelocation, "w");
        fwrite($file, $encrypted_image);
        fclose($file);
        return back()->with('success', 'Image Encryted Successfully');
        //return $this->DataEncryption($image_bytes, $request->input('encrypt_key'));
    }


    public function DecryptFile(Request $request)
    {
        $request->validate([
            'file'=>'required|mimetypes:text/plain',
            'decrypt_key'=>'required'
        ]);

        //retrieve data from uploaded file
        $filelocation  = ('C:\\Windows\Temp\\'.'encrypted.txt');
        $file = fopen($filelocation, "r");

        $data = fread($file,filesize($filelocation));
        fclose($file);


        $data = $this->DataDecryption($data, $request->input('decrypt_key'));
        //return view('decryption',['EncryptedData' => $data]);
        return back()->with('EncryptedData', $data);
        //return $data;
    }

    public function DataEncryption($data, $key)
    {
        $base64 = base64_encode('AESEncryption');
        $public_key = hash_hmac('sha1', $base64, $key,false);//

        // Store the cipher method
        $ciphering = "AES-256-CBC";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = hash_hmac('sha256', $public_key, $key,false);
        $encryption_iv = substr($encryption_iv,0,16);

        // Store the encryption key
        $encryption_key = $public_key;

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($data, $ciphering,$encryption_key, $options, $encryption_iv);

        return $encryption;
    }

    public function DataDecryption($data,$key)
    {
        $base64 = base64_encode('AESEncryption');
        $public_key = hash_hmac('sha1', $base64, $key,false);

        // Store the cipher method
        $ciphering = "AES-256-CBC";
        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = hash_hmac('sha256', $public_key, $key,false);
        $decryption_iv = substr($decryption_iv,0,16);

        // Store the decryption key
        $decryption_key = $public_key;

        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($data, $ciphering,$decryption_key, $options, $decryption_iv);

        return $decryption;
    }

}
