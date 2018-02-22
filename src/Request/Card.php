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
 * Request Card.
 *
 * @package ElGigi\LyraPayments\Request
 *
 * @property string $paymentToken       Credit card token
 * @property string $number             Credit card number
 * @property string $scheme             Credit card type
 * @property string $expiryMonth        Credit card month
 * @property string $expiryYear         Credit card year
 * @property string $cardSecurityCode   Credit card security code
 * @property string $cardHolderBirthday Credit card holder birthday
 */
class Card extends AbstractObject
{
    /**
     * Card constructor.
     *
     * @param array $data Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['paymentToken'       => 'ans..64',
                             'number'             => 'string',
                             'scheme'             => '[AMEX,CB,MASTERCARD,VISA,VISA_ELECTRON,MAESTRO,E-CARTEBLEUE,JCB]',
                             'expiryMonth'        => 'n..2',
                             'expiryYear'         => 'n4',
                             'cardSecurityCode'   => 'n..4',
                             'cardHolderBirthday' => 'datetime'],
                            $data);
    }
}