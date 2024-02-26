<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Message\NotificationInterface;

class AcceptNotificationResponse extends CompletePurchaseResponse implements NotificationInterface
{
    /**
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->isSuccessful() ? self::STATUS_COMPLETED : self::STATUS_FAILED;
    }
}
