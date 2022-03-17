<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\LyraPayments\Info;

use ElGigi\LyraPayments\AbstractObject;
use ElGigi\LyraPayments\Exception\LyraPaymentsException;

/**
 * Info Ext.
 *
 * @package ElGigi\LyraPayments\Info
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
     *
     * @throws LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(
            [
                'key' => 'string',
                'value' => 'string'
            ],
            $data
        );
    }
}