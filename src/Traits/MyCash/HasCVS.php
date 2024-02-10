<?php

namespace Omnipay\ePays\Traits\MyCash;

trait HasCVS
{
    public function getChooseStoreID()
    {
        return $this->getParameter('ChooseStoreID');
    }

    public function setChooseStoreID($value)
    {
        return $this->setParameter('ChooseStoreID', $value);
    }
}
