<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\LyraPayments\Request;

use ElGigi\LyraPayments\AbstractObject;

/**
 * Request Customer.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property \ElGigi\LyraPayments\Request\BillingDetails  $billingDetails  Billing details
 * @property \ElGigi\LyraPayments\Request\ShippingDetails $shippingDetails Shipping details
 * @property \ElGigi\LyraPayments\Request\ExtraDetails    $extraDetails    Extra details
 */
class Customer extends AbstractObject
{
    /**
     * Card constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['billingDetails'  => 'ElGigi\LyraPayments\Request\BillingDetails',
                             'shippingDetails' => 'ElGigi\LyraPayments\Request\ShippingDetails',
                             'extraDetails'    => 'ElGigi\LyraPayments\Request\ExtraDetails'],
                            $data);
    }
}