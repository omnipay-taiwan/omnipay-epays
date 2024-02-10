<?php

namespace Omnipay\ePays;

use Omnipay\Common\AbstractGateway;
use Omnipay\ePays\Message\AcceptNotificationRequest;
use Omnipay\ePays\Message\CompletePurchaseRequest;
use Omnipay\ePays\Message\FetchTransactionRequest;
use Omnipay\ePays\Message\PurchaseRequest;
use Omnipay\ePays\Message\GetPaymentInfoRequest;
use Omnipay\ePays\Traits\HasEpays;

/**
 * MyCash Gateway
 */
class Gateway extends AbstractGateway
{
    use HasEpays;

    public function getName(): string
    {
        return 'MyCash';
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
