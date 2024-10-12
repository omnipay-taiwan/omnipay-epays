<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\EPays\Encryptor;
use Omnipay\EPays\Traits\XWallet\HasEPays;

class PurchaseRequest extends AbstractRequest
{
    use HasEPays;

    /**
     * 特店訂單編號
     *
     * @param  string  $value
     */
    public function setFirmOrderNo($value)
    {
        return $this->setTransactionId($value);
    }

    /**
     * @return string
     */
    public function getFirmOrderNo()
    {
        return $this->getTransactionId();
    }

    /**
     * 支付方式 1：信用卡2、虛擬
     *
     * @param  int  $value
     */
    public function setPayType($value)
    {
        return $this->setPaymentMethod($value);
    }

    /**
     * @return ?int
     */
    public function getPayType()
    {
        return $this->getPaymentMethod();
    }

    /**
     * 金額
     *
     * @param  int  $value
     */
    public function setPrice($value)
    {
        return $this->setAmount($value);
    }

    /**
     * @return string
     *
     * @throws InvalidRequestException
     */
    public function getPrice()
    {
        return $this->getAmount();
    }

    /**
     * 消費者手機
     *
     * @param  string  $value
     */
    public function setMobile($value)
    {
        return $this->setParameter('Mobile', $value);
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->getParameter('Mobile');
    }

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return [
            'FirmOrderNo' => $this->getTransactionId(),
            'PayType' => (int) $this->getPaymentMethod() ?: 1,
            'Price' => (int) $this->getAmount(),
            'Mobile' => $this->getMobile(),
        ];
    }

    public function sendData($data)
    {
        $encryptor = new Encryptor($this->getHashKey(), $this->getHashIV());

        return new PurchaseResponse($this, [
            'Hashkey' => $this->getHashKey(),
            'data' => $encryptor->encrypt($data),
        ]);
    }
}
