<?php

namespace ElGigi\SystemPay\Model;

/**
 * Class ShoppingCartRequest.
 *
 * @package ElGigi\SystemPay\Model
 *
 * @property int          $insuranceAmount Insurance amount
 * @property int          $shippingAmount  Shipping amount
 * @property int          $taxAmount       Tax amount
 * @property CartItemInfo $cartItemInfo    Cart item info
 */
class ShoppingCartRequest extends Object
{
    /**
     * ShoppingCartRequest constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['insuranceAmount' => 'n..3',
                             'shippingAmount'  => 'n..3',
                             'taxAmount'       => 'n..3',
                             'cartItemInfo'    => 'SystemPay\model\CartItemInfo'],
                            $data);
    }
}