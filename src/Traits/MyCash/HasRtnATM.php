<?php

namespace Omnipay\EPays\Traits\MyCash;

trait HasRtnATM
{
    public function getATMNo()
    {
        return $this->getParameter('ATMNo');
    }

    public function setATMNo($value)
    {
        return $this->setParameter('ATMNo', $value);
    }
}
