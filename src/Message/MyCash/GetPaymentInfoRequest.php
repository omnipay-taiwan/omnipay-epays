<?php

namespace Omnipay\EPays\Message\MyCash;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\EPays\Traits\MyCash\HasMyCash;

class GetPaymentInfoRequest extends AbstractRequest
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

        if (! hash_equals($this->httpRequest->request->get('Validate'), $this->makeHash($data))) {
            throw new InvalidResponseException('Incorrect hash');
        }

        return $data;
    }

    /**
     * @param  array  $data
     * @return GetPaymentInfoResponse
     */
    public function sendData($data)
    {
        return $this->response = new GetPaymentInfoResponse($this, $data);
    }
}
