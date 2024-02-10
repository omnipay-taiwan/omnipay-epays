<?php

namespace Omnipay\ePays\Message;

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
