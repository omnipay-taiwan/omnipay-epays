<?php

namespace Omnipay\ePays\Tests\Message\XWallet;

use Omnipay\ePays\Encryptor;
use Omnipay\ePays\Message\XWallet\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'HashIV' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    ];

    public function testGetData(): void
    {
        $encryptor = new Encryptor($this->initialize['HashKey'], $this->initialize['HashIV']);
        $data = $encryptor->encrypt([
            'FirmOrderNo' => 'test202309011123001',
            'PayNo' => '460199********8103',
            'PriceReal' => 100,
        ]);
        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => '1',
            'code' => '200',
            'msg' => '交易成功',
            'data' => $data,
        ]));
        $httpRequest->setMethod('POST');
        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));

        self::assertEquals([
            'state' => '1',
            'code' => '200',
            'msg' => '交易成功',
            'data' => $data,
        ], $request->getData());
    }
}
