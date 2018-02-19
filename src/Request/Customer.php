<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

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
     *
     * @throws \ElGigi\SystemPay\Exception\SystemPayException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['billingDetails'  => 'ElGigi\SystemPay\Request\BillingDetails',
                             'shippingDetails' => 'ElGigi\SystemPay\Request\ShippingDetails',
                             'extraDetails'    => 'ElGigi\SystemPay\Request\ExtraDetails'],
                            $data);
    }
}