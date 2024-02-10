<?php

namespace Omnipay\ePays\Tests\Message\XWallet;

use Omnipay\ePays\Message\XWallet\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'HashIV' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    ];

    public function testGetData(): void
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }
}
