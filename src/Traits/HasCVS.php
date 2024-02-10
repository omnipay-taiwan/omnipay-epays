<?php

namespace Omnipay\ePays\Traits;

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
