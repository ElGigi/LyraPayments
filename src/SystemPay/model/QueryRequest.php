<?php
namespace SystemPay\model;

/**
 * Class QueryRequest
 *
 * @package SystemPay\model
 *
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
        parent::__construct(['paymentToken' => 'ans..64'], $data);
    }
}