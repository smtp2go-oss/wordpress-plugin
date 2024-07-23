<?php

namespace SMTP2GO\App;

class SecureApiKeyHelper
{

    const CIPHER = 'AES-256-CTR';

    private $ivlen = 0;

    private $key = 'default-key-not-secure';

    public function __construct()
    {
        $this->ivlen = openssl_cipher_iv_length(self::CIPHER);
        $this->key = defined('AUTH_KEY') ? AUTH_KEY : $this->key;
    }

    public function encryptKey($plain)
    {
        if (!extension_loaded('openssl')) {
            return $plain;
        }
        if (!in_array(strtolower(self::CIPHER), openssl_get_cipher_methods())) {
            return $plain;
        }

        $iv = openssl_random_pseudo_bytes($this->ivlen);

        $encrypted = openssl_encrypt($plain, self::CIPHER, $this->key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function decryptKey($maybeEncryptedKey)
    {
        if (!extension_loaded('openssl')) {
            return $maybeEncryptedKey;
        }

        if (!in_array(strtolower(self::CIPHER), openssl_get_cipher_methods())) {
            return $maybeEncryptedKey;
        }

        if (strpos($maybeEncryptedKey, 'api-') !== 0) {

            $encrypted = base64_decode($maybeEncryptedKey);

            $iv = substr($encrypted, 0, $this->ivlen);

            $encrypted = substr($encrypted, $this->ivlen);

            return openssl_decrypt($encrypted, self::CIPHER, $this->key, 0, $iv);
        }

        return $maybeEncryptedKey;
    }
}
