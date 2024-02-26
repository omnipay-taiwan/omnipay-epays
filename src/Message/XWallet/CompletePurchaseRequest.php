<?php

namespace Omnipay\EPays\Message\XWallet;

use Exception;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Traits\XWallet\HasEPays;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasEPays;

    /**
     * @throws InvalidResponseException
     */
    public function getData()
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

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}
