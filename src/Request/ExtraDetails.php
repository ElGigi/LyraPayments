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
 * Request ExtraDetails.
 *
 * @package ElGigi\SystemPay\Request
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
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['ipAddress'     => 'ans40',
                             'fingerPrintId' => 'ans128'],
                            $data);
    }
}