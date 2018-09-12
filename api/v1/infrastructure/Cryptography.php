<?php

class Cryptography {
    private $password = '3zsc3RLrpd17';
    private $method = 'aes-256-cbc';
    private $iv= '';

    public function __construct() {
        // Must be exact 32 chars (256 bit)
        $this->password = substr(hash('sha256', $password, true), 0, 32);
        // IV must be exact 16 chars (128 bit)
        $this->iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }

    //sifreleme
    public function Encode($encryptText){
        return base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));
    }

    //Cozme
    public function Decode($decryptText) {
        return openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);
    }
}

?>