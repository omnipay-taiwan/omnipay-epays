<?php

namespace Omnipay\EPays\Traits\XWallet;

use Exception;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\EPays\Encryptor;

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

    /**
     * @throws InvalidResponseException
     */
    protected function decrypt()
    {
        try {
            $data = json_decode($this->httpRequest->getContent(), true);
            $encryptor = new Encryptor($this->getHashKey(), $this->getHashIV());
            $data['data'] = $encryptor->decrypt($data['data']);
        } catch (Exception $e) {
            throw new InvalidResponseException('Decrypt data failed', 0, $e);
        }

        if (empty($data['data'])) {
            throw new InvalidResponseException('Decrypt data failed');
        }

        return $data;
    }
}
