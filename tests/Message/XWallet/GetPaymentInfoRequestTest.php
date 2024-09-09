<?php

namespace Omnipay\EPays\Tests\Message\XWallet;

use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Message\XWallet\GetPaymentInfoRequest;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GetPaymentInfoRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'HashIV' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    ];

    public function testGetDataForAtm()
    {
        $encryptor = new Encryptor($this->initialize['HashKey'], $this->initialize['HashIV']);
        $data = [
            'FirmOrderNo' => 'test202309011123001',
            'PayBankCode' => '001',
            'PayBankAccount' => '2592600213085401',
            'PriceReal' => 100,
        ];
        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => 1,
            'code' => 201,
            'msg' => '繳費代碼或帳號取得成功',
            'data' => $encryptor->encrypt($data),
            'FirmOrderNo' => 'test202309011123001',
        ]));
        $httpRequest->setMethod('POST');
        $request = new GetPaymentInfoRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));
        $response = $request->send();

        self::assertFalse($response->isSuccessful());
        self::assertEquals('繳費代碼或帳號取得成功', $response->getMessage());
        self::assertEquals('test202309011123001', $response->getTransactionId());
    }

    public function testGetDataForCvs()
    {
        $encryptor = new Encryptor($this->initialize['HashKey'], $this->initialize['HashIV']);
        $data = [
            'FirmOrderNo' => 'test202309011123001',
            'PayBankCode' => '',
            'PayBankAccount' => '2592600213085401',
            'PriceReal' => 100,
        ];
        $httpRequest = new HttpRequest([], [], [], [], [], [], json_encode([
            'state' => 1,
            'code' => 201,
            'msg' => '繳費代碼或帳號取得成功',
            'data' => $encryptor->encrypt($data),
            'FirmOrderNo' => 'test202309011123001',
        ]));
        $httpRequest->setMethod('POST');
        $request = new GetPaymentInfoRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));
        $response = $request->send();

        self::assertFalse($response->isSuccessful());
        self::assertEquals('繳費代碼或帳號取得成功', $response->getMessage());
        self::assertEquals('test202309011123001', $response->getTransactionId());
    }
}
