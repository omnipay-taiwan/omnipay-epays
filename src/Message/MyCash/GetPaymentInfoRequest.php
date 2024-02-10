<?php

namespace Omnipay\ePays\Message\MyCash;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\ePays\Traits\MyCash\HasMyCash;

class GetPaymentInfoRequest extends AbstractRequest
{
    use HasMyCash;

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();

        if (! hash_equals($this->httpRequest->request->get('Validate'), $this->makeHash($data))) {
            throw new InvalidRequestException('Incorrect hash');
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
