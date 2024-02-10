<?php

namespace Omnipay\ePays\Message\XWallet;

use Omnipay\ePays\Traits\XWallet\HasEPays;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasEPays;

    public function getData()
    {
        return json_decode($this->httpRequest->getContent(), true);
    }

    public function sendData($data)
    {
    }
}
