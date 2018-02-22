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
 * Request ThreeDS.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $mode      3DS mode
 * @property string $requestId Request id
 * @property string $pares     PaRes message
 * @property string $brand     Brand card
 * @property string $enrolled  Enrolment status
 * @property string $eci       E-commerce indicator
 * @property string $xid       3DS transaction id
 * @property string $cavv      ACS certificate
 * @property string $algorithm Algorithm
 */
class ThreeDS extends AbstractObject
{
    /**
     * ThreeDS constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['mode'      => '[DISABLED,ENABLED_CREATE,ENABLED_FINALIZE]',
                             'requestId' => 'string',
                             'pares'     => 'string',
                             'brand'     => 'string',
                             'enrolled'  => '[Y,N,U]',
                             'eci'       => 'string',
                             'xid'       => 'string',
                             'cavv'      => 'string',
                             'algorithm' => '[0,1,2,3]'],
                            $data);
    }
}