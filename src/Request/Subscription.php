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
 * Request Subscription.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $effectDate          Effect date
 * @property string $amount              Amount
 * @property string $currency            Currency
 * @property string $initialAmount       Initial amount
 * @property string $initialAmountNumber Initial amount number
 * @property string $rrule               Rules
 * @property string $subscriptionId      Subscription id
 * @property string $description         Description
 */
class Subscription extends AbstractObject
{
    /**
     * Subscription constructor.
     *
     * @param array $data Default data
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'effectDate' => 'datetime',
                'amount' => 'n..12',
                'currency' => 'n3',
                'initialAmount' => 'n..12',
                'initialAmountNumber' => 'int',
                'rrule' => 'string',
                'subscriptionId' => 'string',
                'description' => 'string'
            ],
            $data
        );
    }
}