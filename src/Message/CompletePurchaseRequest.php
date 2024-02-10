<?php

namespace Omnipay\ePays\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\ePays\Traits\HasEpays;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasEpays;

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $validate = $data['Validate'];

        if ($this->makeHash($data) !== $validate) {
            throw new InvalidRequestException('Incorrect hash');
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
