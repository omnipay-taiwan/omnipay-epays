<?php

namespace Omnipay\ePays\Traits\XWallet;

trait HasEPays
{
    public function getHashKey()
    {
        return $this->getParameter('HashKey');
    }

    public function setHashKey($value)
    {
        return $this->setParameter('HashKey', $value);
    }

    public function getHashIV()
    {
        return $this->getParameter('HashIV');
    }

    public function setHashIV($value)
    {
        return $this->setParameter('HashIV', $value);
    }
}
