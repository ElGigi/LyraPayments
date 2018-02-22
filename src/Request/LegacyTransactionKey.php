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
 * Request LegacyTransactionKey.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $transactionId  Transaction id
 * @property string $sequenceNumber Sequence number
 * @property string $creationDate   Create date time
 */
class LegacyTransactionKey extends AbstractObject
{
    /**
     * LegacyTransactionKey constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['transactionId'  => 'string',
                             'sequenceNumber' => 'n..3',
                             'creationDate'   => 'datetime'],
                            $data);
    }
}