<?php

namespace Omnipay\EPays\Message\MyCash;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\EPays\Traits\MyCash\HasMyCash;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasMyCash;

    /**
     * @return array
     *
     * @throws InvalidResponseException
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $validate = array_key_exists('Validate', $data) ? $data['Validate'] : '';

        if ($this->makeHash($data) !== $validate) {
            throw new InvalidResponseException('Incorrect hash');
        }

        return $data;
    }

    /**
     * @param  array  $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
