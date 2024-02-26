<?php

namespace Omnipay\EPays;

class Hasher
{
    private $hashKey;

    private $validateKey;

    public function __construct($hashKey, $validateKey)
    {
        $this->hashKey = $hashKey;
        $this->validateKey = $validateKey;
    }

    public function make(array $data)
    {
        $columns = [
            'ValidateKey' => $this->validateKey,
            'HashKey' => $this->hashKey,
        ];
        foreach (['RtnCode', 'TradeID', 'UserID', 'Money'] as $key) {
            if (array_key_exists($key, $data)) {
                $columns[$key] = $data[$key];
            }
        }

        $results = [];
        foreach ($columns as $key => $value) {
            $results[] = "$key=$value";
        }

        return md5(implode('&', $results));
    }
}
