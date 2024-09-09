<?php

namespace Omnipay\EPays\Message\XWallet;

class GetPaymentInfoResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false;
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
        return $this->data['FirmOrderNo'];
    }
}
