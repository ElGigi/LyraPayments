<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Customer.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property \ElGigi\SystemPay\Request\BillingDetails  $billingDetails  Billing details
 * @property \ElGigi\SystemPay\Request\ShippingDetails $shippingDetails Shipping details
 * @property \ElGigi\SystemPay\Request\ExtraDetails    $extraDetails    Extra details
 */
class Customer extends AbstractObject
{
    /**
     * Card constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['billingDetails'  => 'ElGigi\SystemPay\Request\BillingDetails',
                             'shippingDetails' => 'ElGigi\SystemPay\Request\ShippingDetails',
                             'extraDetails'    => 'ElGigi\SystemPay\Request\ExtraDetails'],
                            $data);
    }
}