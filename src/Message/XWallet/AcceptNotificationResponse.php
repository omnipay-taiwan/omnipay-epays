<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Message\NotificationInterface;

class AcceptNotificationResponse extends AbstractResponse implements NotificationInterface
{
    public function isSuccessful()
    {
        return (int) $this->getCode() === 200;
    }

    public function getCode()
    {
        return $this->data['code'];
    }

    public function getMessage()
    {
        return $this->data['msg'];
    }

    public function getTransactionId()
    {
        return $this->data['FirmOrderNo'];
    }

    /**
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->isSuccessful() ? self::STATUS_COMPLETED : self::STATUS_FAILED;
    }

    /**
     * @return string
     */
    public function getReply()
    {
        return 'OK';
    }
}
