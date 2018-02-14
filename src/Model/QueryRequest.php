<?php

namespace ElGigi\SystemPay\Model;

/**
 * Class QueryRequest.
 *
 * @package ElGigi\SystemPay\Model
 *
 * @property string $uuid         Unique id transaction reference
 * @property string $paymentToken Credit card token
 */
class QueryRequest extends Object
{
    /**
     * QueryRequest constructor.
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