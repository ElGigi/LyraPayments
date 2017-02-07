<?php
namespace SystemPay\model;

/**
 * Class OrderRequest
 *
 * @package SystemPay\model
 *
 * @property string  $orderId Order id
 * @property ExtInfo $extInfo Variable
 */
class OrderRequest extends Object
{
    /**
     * OrderRequest constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['orderId' => 'an..64',
                             'extInfo' => 'SystemPay\model\ExtInfo'],
                            $data);
    }
}