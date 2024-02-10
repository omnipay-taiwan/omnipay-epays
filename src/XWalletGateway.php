<?php

namespace Omnipay\ePays;

use Omnipay\Common\AbstractGateway;
use Omnipay\ePays\Message\XWallet\PurchaseRequest;
use Omnipay\ePays\Traits\XWallet\HasEPay;

/**
 * MyCash Gateway
 */
class XWalletGateway extends AbstractGateway
{
    use HasEPay;

    public function getName(): string
    {
        return 'ePays_XWallet';
    }

    public function getDefaultParameters(): array
    {
        return [
            'HashKey' => '',
            'HashIV' => '',
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }
}
