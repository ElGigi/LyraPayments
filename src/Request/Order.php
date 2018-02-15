<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Order.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string                     $orderId Order id
 * @property \ElGigi\SystemPay\Info\Ext $extInfo Variable
 */
class Order extends AbstractObject
{
    /**
     * Order constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['orderId' => 'an..64',
                             'extInfo' => 'ElGigi\SystemPay\Info\Ext'],
                            $data);
    }
}