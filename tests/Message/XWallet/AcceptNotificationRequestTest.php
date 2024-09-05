<?php

namespace Omnipay\EPays\Tests\Message\XWallet;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Message\XWallet\AcceptNotificationRequest;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class AcceptNotificationRequestTest extends TestCase
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
        $request = new AcceptNotificationRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge($this->initialize, []));

        self::assertEquals('交易成功', $request->getMessage());
        self::assertEquals('OK', $request->getReply());
        self::assertEquals('test202309011123001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
    }


}
