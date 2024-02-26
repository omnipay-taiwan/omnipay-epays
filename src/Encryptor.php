<?php

namespace Omnipay\EPays;

use LengthException;
use phpseclib3\Crypt\AES;

class Encryptor
{
    /**
     * @var AES
     */
    private $cipher;

    public function __construct($key, $iv)
    {
        $this->cipher = new AES('cbc');
        $this->cipher->setKey($this->padding($key));
        $this->cipher->setIV(substr($iv, 0, 16));
    }

    public function encrypt($data)
    {
        return base64_encode($this->cipher->encrypt(json_encode($data)));
    }

    private function padding($key)
    {
        return str_pad($key, self::getKeySize($key), "\0");
    }

    private static function getKeySize($key)
    {
        $length = strlen($key);
        $sizes = [16, 24, 32];
        foreach ($sizes as $size) {
            if ($length < $size) {
                return $size;
            }
        }

        throw new LengthException(
            'Key of size '.$length.' not supported by this algorithm. Only keys of sizes 128, 192 or 256 supported'
        );
    }

    public function decrypt($plainText)
    {
        return json_decode($this->cipher->decrypt(
            base64_decode($plainText)
        ), true);
    }
}
