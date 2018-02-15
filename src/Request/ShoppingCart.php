<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request ShoppingCart.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property int                             $insuranceAmount Insurance amount
 * @property int                             $shippingAmount  Shipping amount
 * @property int                             $taxAmount       Tax amount
 * @property \ElGigi\SystemPay\Info\CartItem $cartItemInfo    Cart item info
 */
class ShoppingCart extends AbstractObject
{
    /**
     * ShoppingCart constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['insuranceAmount' => 'n..3',
                             'shippingAmount'  => 'n..3',
                             'taxAmount'       => 'n..3',
                             'cartItemInfo'    => 'ElGigi\SystemPay\Info\CartItem'],
                            $data);
    }
}