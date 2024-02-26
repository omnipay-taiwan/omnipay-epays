<?php

namespace Omnipay\EPays\Tests;

use Omnipay\EPays\Encryptor;
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

    public function testDecrypt()
    {
        $data = 'u4OlyM8T0QFQPQkL8XhzfzbRQgoPeJauC/hntXPi7Mt2koLqMbjzRbOCOWOwkIgDYTyGgtCrigF0yJ9vP0eKYPjwQUspyhVKdUK6+RVTBE4aBX998OOJ+zwxO0c8f5ZJ';

        $encryptor = new Encryptor($this->key, $this->iv);

        self::assertEquals([
            'FirmOrderNo' => 'test202308301722001',
            'o_PayNo' => '460199********8103',
            'o_PriceReal' => 100,
        ], $encryptor->decrypt($data));
        self::assertEquals($this->opensslDecrypt($data), $encryptor->decrypt($data));
    }

    private function opensslEncrypt($data)
    {
        $data = json_encode($data);
        $HashIv = substr($this->iv, 0, 16);
        $hash = openssl_encrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $HashIv);

        return base64_encode($hash);
    }

    /**
     * @return mixed
     */
    private function opensslDecrypt(string $data)
    {
        $HashIv = substr($this->iv, 0, 16);
        $str = base64_decode($data);
        $str = openssl_decrypt($str, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $HashIv);

        return json_decode($str, true);
    }
}
