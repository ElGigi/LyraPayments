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
use ElGigi\LyraPayments\Exception\LyraPaymentsException;
use ElGigi\LyraPayments\Info\CartItem;

/**
 * Request ShoppingCart.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property int $insuranceAmount Insurance amount
 * @property int $shippingAmount  Shipping amount
 * @property int $taxAmount       Tax amount
 * @property CartItem $cartItemInfo    Cart item info
 */
class ShoppingCart extends AbstractObject
{
    /**
     * ShoppingCart constructor.
     *
     * @param array $data Default data
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'insuranceAmount' => 'n..3',
                'shippingAmount' => 'n..3',
                'taxAmount' => 'n..3',
                'cartItemInfo' => 'ElGigi\LyraPayments\Info\CartItem'
            ],
            $data
        );
    }
}