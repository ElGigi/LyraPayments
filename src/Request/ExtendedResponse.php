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
 * Request ExtendedResponse.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $isNsuRequested If need extended response
 */
class ExtendedResponse extends AbstractObject
{
    /**
     * ExtendedResponse constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['isNsuRequested' => 'n1'], $data);
    }
}