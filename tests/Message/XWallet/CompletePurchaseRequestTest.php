<?php

namespace Omnipay\EPays\Tests\Message\XWallet;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Message\XWallet\CompletePurchaseRequest;
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
        $data = [
            'FirmOrderNo' => 'test202309011123001',
            'PayNo' => '460199********8103',
            'PriceReal' => 100,
        ];
        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => '1',
            'code' => '200',
            'msg' => '交易成功',
            'data' => $encryptor->encrypt($data),
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

    public function testSend(): void
    {
        $encryptor = new Encryptor($this->initialize['HashKey'], $this->initialize['HashIV']);
        $data = $encryptor->encrypt([
            'FirmOrderNo' => 'test202309011123001',
            'PayNo' => '460199********8103',
            'PriceReal' => 100,
        ]);
        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => 1,
            'code' => 200,
            'msg' => '交易成功',
            'data' => $data,
        ]));
        $httpRequest->setMethod('POST');
        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));

        $response = $request->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('交易成功', $response->getMessage());
        self::assertEquals('200', $response->getCode());
        self::assertEquals('test202309011123001', $response->getTransactionId());
    }

    public function testDecryptFailed()
    {
        $this->expectException(InvalidResponseException::class);

        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => 1,
            'code' => 200,
            'msg' => '交易成功',
            'data' => 'fake data',
        ]));
        $httpRequest->setMethod('POST');
        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));

        $request->send();
    }
}
