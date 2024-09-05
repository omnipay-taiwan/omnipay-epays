<?php

namespace Omnipay\EPays\Message\XWallet;

class GetPaymentInfoResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return (int) $this->getCode() === 201;
    }

    public function getCode()
    {
        return $this->data['code'];
    }

    public function getMessage()
    {
        return $this->data['msg'];
    }

    public function getTransactionId()
    {
        return $this->data['data']['FirmOrderNo'];
    }
}
