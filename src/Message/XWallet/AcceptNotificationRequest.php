<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\EPays\Traits\XWallet\HasEPays;

class AcceptNotificationRequest extends AbstractRequest implements NotificationInterface
{
    use HasEPays;

    /**
     * @throws InvalidResponseException
     */
    public function getData()
    {
        return $this->decrypt();
    }

    /**
     * @param  array  $data
     * @return AcceptNotificationResponse
     */
    public function sendData($data)
    {
        return $this->response = new AcceptNotificationResponse($this, $data);
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getNotificationResponse()->getTransactionId();
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->getNotificationResponse()->getTransactionReference();
    }

    /**
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->getNotificationResponse()->getTransactionStatus();
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getNotificationResponse()->getMessage();
    }

    /**
     * @return string
     */
    public function getReply()
    {
        return $this->getNotificationResponse()->getReply();
    }

    /**
     * @return AcceptNotificationResponse
     */
    private function getNotificationResponse()
    {
        return ! $this->response ? $this->send() : $this->response;
    }
}
