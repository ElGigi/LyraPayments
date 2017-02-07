<?php
namespace SystemPay\model;

/**
 * Class CardRequest
 *
 * @package SystemPay\model
 *
 * @property string $paymentToken       Credit card token
 * @property string $number             Credit card number
 * @property string $scheme             Credit card type
 * @property string $expiryMonth        Credit card month
 * @property string $expiryYear         Credit card year
 * @property string $cardSecurityCode   Credit card security code
 * @property string $cardHolderBirthday Credit card holder birthday
 */
class CardRequest extends Object
{
    /**
     * CardRequest constructor.
     *
     * @param array $data Default data
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