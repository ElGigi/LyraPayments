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
 * Request Payment.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $amount              Payment amount
 * @property string $currency            Payment currency
 * @property string $expectedCaptureDate Payment expected capture date
 * @property string $manualValidation    Manual validation
 */
class Payment extends AbstractObject
{
    /**
     * Payment constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['amount'              => 'n..12',
                             'currency'            => 'n3',
                             'expectedCaptureDate' => 'datetime',
                             'manualValidation'    => 'n1'],
                            $data);
    }
}