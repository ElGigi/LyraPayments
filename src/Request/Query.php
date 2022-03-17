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

/**
 * Request Query.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $uuid         Unique id transaction reference
 * @property string $paymentToken Credit card token
 */
class Query extends AbstractObject
{
    /**
     * Query constructor.
     *
     * @param array $data Default data
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'uuid' => 'string',
                'paymentToken' => 'ans..64'
            ],
            $data
        );
    }
}