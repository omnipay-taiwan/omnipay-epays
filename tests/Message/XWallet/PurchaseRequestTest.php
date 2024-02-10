<?php

namespace Omnipay\ePays\Tests\Message\XWallet;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\ePays\Message\XWallet\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'HashIV' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
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
            'Mobile' => '0912345678',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($this->initialize, $options));

        self::assertEquals([
            'FirmOrderNo' => 'test202309011123001',
            'PayType' => 1,
            'Price' => 100,
            'Mobile' => '0912345678',
        ], $request->getData());
    }
}
