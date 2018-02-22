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
 * Request ExtraDetails.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $ipAddress     IP address
 * @property string $fingerPrintId Unique session id
 */
class ExtraDetails extends AbstractObject
{
    /**
     * ExtraDetails constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['ipAddress'     => 'ans40',
                             'fingerPrintId' => 'ans128'],
                            $data);
    }
}