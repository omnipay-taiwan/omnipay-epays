<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Traits\XWallet\HasEPays;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasEPays;

    public function getData()
    {
        $data = json_decode($this->httpRequest->getContent(), true);
        $encryptor = new Encryptor($this->getHashKey(), $this->getHashIV());
        $data['data'] = $encryptor->decrypt($data['data']);

        return $data;
    }

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}
