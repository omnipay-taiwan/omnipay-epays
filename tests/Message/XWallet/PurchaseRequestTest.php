<?php

namespace Omnipay\EPays\Tests\Message\XWallet;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\EPays\Message\XWallet\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'HashIV' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'testMode' => '1',
    ];

    /**
     * @throws InvalidRequestException
     */
    public function testGetData(): void
    {
        $options = [
            'transactionId' => 'test202309011123001',
            'amount' => 100,
            'PayType' => 1,
            'PayMode' => 4,
            'Mobile' => '0912345678',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($this->initialize, $options));

        self::assertEquals([
            'FirmOrderNo' => 'test202309011123001',
            'PayType' => 1,
            'PayMode' => 4,
            'Price' => 100,
            'Mobile' => '0912345678',
        ], $request->getData());
    }

    public function testSendData()
    {
        $options = [
            'transactionId' => 'test202309011123001',
            'amount' => 100,
            'PayType' => 1,
            'PayMode' => 4,
            'Mobile' => '0912345678',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($this->initialize, $options));

        /** @var RedirectResponseInterface $response */
        $response = $request->send();

        self::assertEquals('http://xpop-test.epays.com.tw/api/o/new', $response->getRedirectUrl());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals([
            'Hashkey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'data' => 'u4OlyM8T0QFQPQkL8XhzfxH5QVFmVcYqUW+hXuic5a+y9cIjEY8qr3gOoIUmOZLuxQ/kHvhMtvcaw2MdnEAgcJfL2SjqVkp3B1MtO3w4yDKWmAMbaYfTxuP2O3T8d4qa',
        ], $response->getRedirectData());
    }
}
