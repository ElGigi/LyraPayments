<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\SystemPay\Info;

use ElGigi\SystemPay\AbstractObject;

/**
 * Info Ext.
 *
 * @package ElGigi\SystemPay\Info
 *
 * @property string $key   Variable key
 * @property string $value Variable value
 */
class Ext extends AbstractObject
{
    /**
     * Ext constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['key'   => 'string',
                             'value' => 'string'],
                            $data);
    }
}