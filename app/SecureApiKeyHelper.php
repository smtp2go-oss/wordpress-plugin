<?php

namespace SMTP2GO\App;

class SecureApiKeyHelper
{

    const CIPHER = 'AES-256-CTR';

    private $ivlen = 0;

    private $key = 'default-key-not-secure';

    public function __construct()
    {
        if (!$this->canEncrypt()) {
            return;
        }

        $this->ivlen = openssl_cipher_iv_length(self::CIPHER);
        $this->key = defined('AUTH_KEY') ? AUTH_KEY : $this->key;
    }

    /**
     * Checks whether the OpenSSL extension is enabled in the system.
     *
     * @return bool
     */
    protected function canEncrypt()
    {
        return \extension_loaded('openssl')
            && in_array(strtolower(self::CIPHER), openssl_get_cipher_methods());
    }

    public function encryptKey($plain)
    {
        if (!$this->canEncrypt()) {
            return $plain;
        }

        $iv = openssl_random_pseudo_bytes($this->ivlen);

        $encrypted = openssl_encrypt($plain, self::CIPHER, $this->key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function decryptKey($maybeEncryptedKey)
    {
        if (!$this->canEncrypt() || strpos($maybeEncryptedKey, 'api-') === 0) {
            return $maybeEncryptedKey;
        }
        
        $encrypted = base64_decode($maybeEncryptedKey);

        $iv = substr($encrypted, 0, $this->ivlen);

        $encrypted = substr($encrypted, $this->ivlen);

        return openssl_decrypt($encrypted, self::CIPHER, $this->key, 0, $iv);
    }
}
