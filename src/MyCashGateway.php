<?php

namespace Omnipay\ePays;

use Omnipay\Common\AbstractGateway;
use Omnipay\ePays\Message\MyCash\AcceptNotificationRequest;
use Omnipay\ePays\Message\MyCash\CompletePurchaseRequest;
use Omnipay\ePays\Message\MyCash\FetchTransactionRequest;
use Omnipay\ePays\Message\MyCash\GetPaymentInfoRequest;
use Omnipay\ePays\Message\MyCash\PurchaseRequest;
use Omnipay\ePays\Traits\MyCash\HasMyCash;

/**
 * MyCash Gateway
 */
class MyCashGateway extends AbstractGateway
{
    use HasMyCash;

    public function getName(): string
    {
        return 'ePays_MyCash';
    }

    public function getDefaultParameters(): array
    {
        return [
            'HashKey' => '',
            'HashIV' => '',
            'ValidateKey' => '',
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = [])
    {
        if ($this->httpRequest->request->get('RtnCode') === '5') {
            return $this->getPaymentInfo($options);
        }

        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function acceptNotification(array $options = [])
    {
        if ($this->httpRequest->request->get('RtnCode') === '5') {
            return $this->getPaymentInfo($options);
        }

        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function getPaymentInfo(array $options = [])
    {
        return $this->createRequest(GetPaymentInfoRequest::class, $options);
    }

    public function fetchTransaction(array $options = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }
}
