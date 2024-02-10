<?php

namespace Omnipay\ePays\Tests;

use Omnipay\ePays\Encryptor;
use PHPUnit\Framework\TestCase;

class EncryptorTest extends TestCase
{
    private $key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $iv = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function testEncrypt()
    {
        $data = [
            'FirmOrderNo' => 'test202309011123001',
            'PayType' => 1,
            'Price' => 100,
            'Mobile' => '0912345678',
        ];

        $encryptor = new Encryptor($this->key, $this->iv);

        $expected = 'u4OlyM8T0QFQPQkL8XhzfxH5QVFmVcYqUW+hXuic5a+y9cIjEY8qr3gOoIUmOZLufZtW/3fDRNP2yQAR2kt4Uaqpq24cR9GTgQBXg5eZDjEzsv4hCE+vXqHdQeNBOe+R';
        self::assertEquals($expected, $encryptor->encrypt($data));
        self::assertEquals($this->opensslEncrypt($data), $encryptor->encrypt($data));
    }

    private function opensslEncrypt($data)
    {
        $data = json_encode($data);
        $HashIv = substr($this->iv, 0, 16);
        $hash = openssl_encrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $HashIv);

        return base64_encode($hash);
    }
}
