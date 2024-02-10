<?php

namespace Omnipay\ePays\Message\XWallet;

use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectUrl()
    {
        return $this->request->getEndpoint().'/api/o/new';
    }

    public function getRedirectData()
    {
        return [
            'Hashkey' => $this->data['Hashkey'],
            'data' => $this->data['data'],
        ];
    }
}
