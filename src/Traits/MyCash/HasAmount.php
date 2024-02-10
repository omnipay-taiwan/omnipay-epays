<?php

namespace Omnipay\ePays\Traits\MyCash;

trait HasAmount
{
    public function getAmount()
    {
        return $this->getParameter('amount');
    }
}
