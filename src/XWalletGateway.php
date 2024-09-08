<?php

namespace Omnipay\EPays;

use Omnipay\Common\AbstractGateway;
use Omnipay\EPays\Message\XWallet\AcceptNotificationRequest;
use Omnipay\EPays\Message\XWallet\GetPaymentInfoRequest;
use Omnipay\EPays\Message\XWallet\PurchaseRequest;
use Omnipay\EPays\Traits\XWallet\HasEPays;

/**
 * MyCash Gateway
 */
class XWalletGateway extends AbstractGateway
{
    use HasEPays;

    public function getName(): string
    {
        return 'EPays_XWallet';
    }

    public function getDefaultParameters(): array
    {
        return [
            'HashKey' => '',
            'HashIV' => '',
            'testMode' => false,
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function acceptNotification(array $options = [])
    {
        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function getPaymentInfo(array $options = [])
    {
        return $this->createRequest(GetPaymentInfoRequest::class, $options);
    }
}
