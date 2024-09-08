<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\EPays\Traits\XWallet\HasEPays;

class GetPaymentInfoRequest extends AbstractRequest
{
    use HasEPays;

    /**
     * @throws InvalidResponseException
     */
    public function getData()
    {
        return $this->decrypt();
    }

    /**
     * @param  array  $data
     * @return GetPaymentInfoResponse
     */
    public function sendData($data)
    {
        return $this->response = new GetPaymentInfoResponse($this, $data);
    }
}
