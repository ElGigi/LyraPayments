<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Query.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $uuid         Unique id transaction reference
 * @property string $paymentToken Credit card token
 */
class Query extends AbstractObject
{
    /**
     * Query constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['uuid'         => 'string',
                             'paymentToken' => 'ans..64'],
                            $data);
    }
}