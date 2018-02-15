<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request ShippingDetails.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $type                      Buyer type
 * @property string $firstName                 Buyer firstname
 * @property string $lastName                  Buyer lastname
 * @property string $phoneNumber               Buyer phone number
 * @property string $email                     Buyer email
 * @property string $streetNumber              Buyer street number
 * @property string $address                   Buyer address
 * @property string $district                  Buyer district
 * @property string $zipCode                   Buyer zip code
 * @property string $city                      Buyer city
 * @property string $state                     Buyer state
 * @property string $country                   Buyer country
 * @property string $deliveryCompanyName       Delivery company name
 * @property string $shippingSpeed             Shipping speed
 * @property string $shippingMethod            Shipping method
 * @property string $legalName                 Buyer company name
 * @property string $identityCode              Buyer identity code
 */
class ShippingDetails extends AbstractObject
{
    /**
     * ShippingDetails constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['type'                => '[PRIVATE,COMPANY]',
                             'firstName'           => 'ans..128',
                             'lastName'            => 'ans..128',
                             'phoneNumber'         => 'ans..32',
                             'email'               => 'ans..150',
                             'streetNumber'        => 'an..5',
                             'address'             => 'ans..255',
                             'address2'            => 'ans..255',
                             'district'            => 'ans..127',
                             'zipCode'             => 'ans..64',
                             'city'                => 'ans..128',
                             'state'               => 'ans..128',
                             'country'             => 'a2',
                             'deliveryCompanyName' => 'ans128',
                             'shippingSpeed'       => '[STANDARD,EXPRESS]',
                             'shippingMethod'      => '[RECLAIM_IN_SHOP,RELAY_POINT,RECLAIM_IN_STATION,PACKAGE_DELIVERY_COMPANY,ETICKET]',
                             'legalName'           => 'ans..128',
                             'identityCode'        => 'ans..255'],
                            $data);
    }
}