<?php

namespace Omnipay\EPays\Traits\MyCash;

trait HasAmount
{
    public function getAmount()
    {
        return $this->getParameter('amount');
    }
}
