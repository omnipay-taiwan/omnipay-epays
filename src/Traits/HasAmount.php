<?php

namespace Omnipay\ePays\Traits;

trait HasAmount
{
    public function getAmount()
    {
        return $this->getParameter('amount');
    }
}
