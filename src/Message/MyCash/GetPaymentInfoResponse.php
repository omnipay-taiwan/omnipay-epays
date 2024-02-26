<?php

namespace Omnipay\EPays\Message\MyCash;

class GetPaymentInfoResponse extends CompletePurchaseResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() === '5';
    }
}
