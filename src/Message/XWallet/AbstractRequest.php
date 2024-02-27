<?php

namespace Omnipay\EPays\Message\XWallet;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    private $liveEndpoint = 'https://xwallet-op.epays.tw';

    private $testEndpoint = 'http://xpop-test.epays.com.tw';

    public function getEndpoint()
    {
        return (bool) $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
