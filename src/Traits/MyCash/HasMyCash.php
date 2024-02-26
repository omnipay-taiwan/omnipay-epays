<?php

namespace Omnipay\EPays\Traits\MyCash;

use Omnipay\EPays\Hasher;

trait HasMyCash
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

    public function getValidateKey()
    {
        return $this->getParameter('ValidateKey');
    }

    public function setValidateKey($value)
    {
        return $this->setParameter('ValidateKey', $value);
    }

    public function getMerTradeID()
    {
        return $this->getTransactionId();
    }

    public function setMerTradeID($value)
    {
        return $this->setTransactionId($value);
    }

    /**
     * @return string
     */
    private function makeHash(array $data)
    {
        $hasher = new Hasher($this->getHashKey(), $this->getValidateKey());
        $lookup = ['RtnCode' => 'RtnCode', 'TradeID' => 'MerTradeID', 'UserID' => 'MerUserID', 'Money' => 'Amount'];
        $result = [];
        foreach ($lookup as $from => $to) {
            if (array_key_exists($to, $data)) {
                $result[$from] = $data[$to];
            }
        }

        return $hasher->make($result);
    }
}
