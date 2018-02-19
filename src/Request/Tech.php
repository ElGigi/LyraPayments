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
 * Request Tech.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $browserUserAgent Browser user agent header value
 * @property string $browserAccept    Browser accept header value
 */
class Tech extends AbstractObject
{
    /**
     * Tech constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\SystemPay\Exception\SystemPayException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['browserUserAgent' => 'string',
                             'browserAccept'    => 'string'],
                            $data);
    }
}