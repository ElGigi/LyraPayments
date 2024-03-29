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
 * Request Common.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $paymentSource  Payment source
 * @property string $submissionDate Submission date time
 * @property string $contractNumber Contract number
 * @property string $comment        Comment
 */
class Common extends AbstractObject
{
    /**
     * Common constructor.
     *
     * @param array $data Default data
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'paymentSource' => '[EC,MOTO,CC,OTHER]',
                'submissionDate' => 'datetime',
                'contractNumber' => 'string',
                'comment' => 'string'
            ],
            $data
        );
    }
}