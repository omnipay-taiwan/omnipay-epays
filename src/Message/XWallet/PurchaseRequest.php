<?php

namespace Omnipay\ePays\Message\XWallet;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\ePays\Traits\XWallet\HasEPays;

class PurchaseRequest extends AbstractRequest
{
    use HasEPays;

    /**
     * 特店訂單編號
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
     * @param  int  $value
     */
    public function setPayType($value)
    {
        return $this->setParameter('PayType', $value);
    }

    /**
     * @return ?int
     */
    public function getPayType()
    {
        return $this->getParameter('PayType');
    }

    /**
     * 金額
     * @param  int  $value
     */
    public function setPrice($value)
    {
        return $this->setAmount($value);
    }

    /**
     * @return string
     * @throws InvalidRequestException
     */
    public function getPrice()
    {
        return $this->getAmount();
    }

    /**
     * 消費者手機
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
            'PayType' => $this->getPayType() ?: 1,
            'Price' => (int) $this->getAmount(),
            'Mobile' => $this->getMobile(),
        ];
    }

    public function sendData($data)
    {
        $data = json_encode($data);
        $HashKey = $this->getHashKey();
        $HashIv = substr($this->getHashIV(), 0, 16);
        $hash = openssl_encrypt($data, 'aes-256-cbc', $HashKey, OPENSSL_RAW_DATA, $HashIv);
        $str = base64_encode($hash);
        var_dump($str === 'u4OlyM8T0QFQPQkL8XhzfxH5QVFmVcYqUW+hXuic5a+y9cIjEY8qr3gOoIUmOZLufZtW/3fDRNP2yQAR2kt4Uaqpq24cR9GTgQBXg5eZDjEzsv4hCE+vXqHdQeNBOe+R');
    }
}
