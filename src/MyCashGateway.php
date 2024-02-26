<?php

namespace Omnipay\EPays;

use Omnipay\Common\AbstractGateway;
use Omnipay\EPays\Message\MyCash\AcceptNotificationRequest;
use Omnipay\EPays\Message\MyCash\CompletePurchaseRequest;
use Omnipay\EPays\Message\MyCash\FetchTransactionRequest;
use Omnipay\EPays\Message\MyCash\GetPaymentInfoRequest;
use Omnipay\EPays\Message\MyCash\PurchaseRequest;
use Omnipay\EPays\Traits\MyCash\HasMyCash;

/**
 * MyCash Gateway
 */
class MyCashGateway extends AbstractGateway
{
    use HasMyCash;

    public function getName(): string
    {
        return 'EPays_MyCash';
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
