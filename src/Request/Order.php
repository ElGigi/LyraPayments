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
use ElGigi\LyraPayments\Info\Ext;

/**
 * Request Order.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $orderId Order id
 * @property Ext $extInfo Variable
 */
class Order extends AbstractObject
{
    /**
     * Order constructor.
     *
     * @param array $data Default data
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'orderId' => 'an..64',
                'extInfo' => 'ElGigi\LyraPayments\Info\Ext'
            ],
            $data
        );
    }
}