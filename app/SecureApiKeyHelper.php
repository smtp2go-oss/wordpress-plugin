<?php

namespace SMTP2GO\App;

class SecureApiKeyHelper
{
    const CIPHER = 'AES-256-CTR';

    private $ivlen = 0;

    private $attemptedKeys = [];

    private $lastUsedKey = "";

    public function __construct()
    {
        if (!$this->canEncrypt()) {
            return;
        }

        $this->ivlen = openssl_cipher_iv_length(self::CIPHER);
    }

    public function getLastUsedKey()
    {
        return $this->lastUsedKey;
    }

    private function attemptKey()
    {
        $default = 'default-key-not-secure';
        $possibleConstants = ['SMTP2GO_ENCRYPTION_KEY', 'AUTH_KEY'];
        foreach ($possibleConstants as $constant) {
            if (
                defined($constant)
                && !empty(constant($constant))
                && !in_array($constant, $this->attemptedKeys)
            ) {
                $this->attemptedKeys[] = $constant;
                return constant($constant);
            }
        }
        if (!in_array($default, $this->attemptedKeys)) {
            $this->attemptedKeys[] = $default;
            return $default;
        }

        return false;
    }

    public function isDecrypted($key)
    {
        if (empty($key) || !is_string($key)) {
            return false;
        }
        return strpos($key, 'api-') === 0;
    }

    /**
     * Checks whether the OpenSSL extension is enabled in the system.
     *
     * @return bool
     */
    public function canEncrypt()
    {
        return \extension_loaded('openssl')
            && in_array(strtolower(self::CIPHER), openssl_get_cipher_methods());
    }

    public function encryptKey($plain)
    {
        if (!$this->canEncrypt() || strpos($plain, 'api-') !== 0) {
            return $plain;
        }

        $this->attemptedKeys = [];

        $iv = openssl_random_pseudo_bytes($this->ivlen);

        $encrypted = openssl_encrypt(
            $plain,
            self::CIPHER,
            $this->attemptKey(),
            0,
            $iv
        );

        $this->attemptedKeys = [];

        return base64_encode($iv . $encrypted);
    }

    public function decryptKey($maybeEncryptedKey, $encKey = null)
    {
        if (!$this->canEncrypt() || $this->isDecrypted($maybeEncryptedKey)) {
            return $maybeEncryptedKey;
        }
        //not something we encrypted (too short to hold an IV + ciphertext), no key will decrypt it
        $raw = is_string($maybeEncryptedKey) ? base64_decode($maybeEncryptedKey, true) : false;
        if ($raw === false || strlen($raw) <= $this->ivlen) {
            $this->attemptedKeys = [];
            return false;
        }
        if ($encKey === null) {
            $this->attemptedKeys = [];
            $this->lastUsedKey = "";
            $encKey = $this->attemptKey();
        }

        if (!$encKey) {
            $this->attemptedKeys = [];
            return false;
        }
        $this->lastUsedKey = $encKey;

        $encrypted = base64_decode($maybeEncryptedKey);

        $iv = substr($encrypted, 0, $this->ivlen);

        $encrypted = substr($encrypted, $this->ivlen);

        $decrypted = openssl_decrypt(
            $encrypted,
            self::CIPHER,
            $this->lastUsedKey,
            0,
            $iv
        );

        //successfully decrypted, return the decrypted value
        if ($this->isDecrypted($decrypted)) {
            return $decrypted;
        }
        //try and decrypt with the next key
        return $this->decryptKey(
            $maybeEncryptedKey,
            $this->attemptKey()
        );
    }
}
