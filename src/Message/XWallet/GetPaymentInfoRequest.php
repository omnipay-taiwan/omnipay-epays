<?php

namespace Omnipay\EPays\Message\XWallet;

class GetPaymentInfoRequest extends CompletePurchaseRequest
{
    /**
     * @param  array  $data
     * @return GetPaymentInfoResponse
     */
    public function sendData($data)
    {
        return $this->response = new GetPaymentInfoResponse($this, $data);
    }
}
