<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request BillingDetails.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $reference         Buyer reference
 * @property string $title             Title of buyer
 * @property string $type              Buyer type
 * @property string $firstName         Buyer firstname
 * @property string $lastName          Buyer lastname
 * @property string $phoneNumber       Buyer phone number
 * @property string $email             Buyer email
 * @property string $streetNumber      Buyer street number
 * @property string $address           Buyer address
 * @property string $district          Buyer district
 * @property string $zipCode           Buyer zip code
 * @property string $city              Buyer city
 * @property string $state             Buyer state
 * @property string $country           Buyer country
 * @property string $identityCode      Buyer identity code
 */
class BillingDetails extends AbstractObject
{
    /**
     * BillingDetails constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['reference'       => 'n..80',
                             'title'           => 'n..80',
                             'type'            => '[PRIVATE,COMPANY]',
                             'firstName'       => 'ans..128',
                             'lastName'        => 'ans..128',
                             'phoneNumber'     => 'ans..32',
                             'email'           => 'ans..150',
                             'streetNumber'    => 'an..5',
                             'address'         => 'ans..255',
                             'district'        => 'ans..127',
                             'zipCode'         => 'ans..64',
                             'city'            => 'ans..128',
                             'state'           => 'ans..128',
                             'country'         => 'a2',
                             'language'        => 'a2',
                             'cellPhoneNumber' => 'ans..32',
                             'identityCode'    => 'ans..255'],
                            $data);
    }
}