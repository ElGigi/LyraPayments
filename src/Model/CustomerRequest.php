<?php
namespace ElGigi\SystemPay\model;

/**
 * Class CustomerRequest
 *
 * @package SystemPay\Model
 *
 * @property BillingDetails  $billingDetails  Billing details
 * @property ShippingDetails $shippingDetails Shipping details
 * @property ExtraDetails    $extraDetails    Extra details
 */
class CustomerRequest extends Object
{
    /**
     * CardRequest constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['billingDetails'  => 'SystemPay\model\BillingDetails',
                             'shippingDetails' => 'SystemPay\model\ShippingDetails',
                             'extraDetails'    => 'SystemPay\model\ExtraDetails'],
                            $data);
    }
}