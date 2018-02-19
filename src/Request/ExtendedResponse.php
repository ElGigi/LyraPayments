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
 * Request ExtendedResponse.
 *
 * @package ElGigi\SystemPay\Request
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
     * @throws \ElGigi\SystemPay\Exception\SystemPayException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['isNsuRequested' => 'n1'], $data);
    }
}