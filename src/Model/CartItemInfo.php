<?php

namespace ElGigi\SystemPay\Model;

/**
 * Class CartItemInfo.
 *
 * @package ElGigi\SystemPay\Model
 *
 * @property string $productLabel  Product label
 * @property string $productType   Product type
 * @property string $productRef    Product reference
 * @property string $productQty    Product quantity
 * @property string $productAmount Product amount
 * @property string $productVat    Product VAT
 */
class CartItemInfo extends Object
{
    /**
     * CartItemInfo constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['productLabel'  => 'string',
                             'productType'   => '[FOOD_AND_GROCERY,AUTOMOTIVE,ENTERTAINMENT,HOME_AND_GARDEN,HOME_APPLIANCE,AUCTION_AND_GROUP_BUYING,FLOWERS_AND_GIFTS,COMPUTER_AND_SOFTWARE,HEALTH_AND_BEAUTY,SERVICE_FOR_INDIVIDUAL,SERVICE_FOR_BUSINESS,SPORTS,CLOTHING_AND_ACCESSORIES,TRAVEL,HOME_AUDIO_PHOTO_VIDEO,TELEPHONY]',
                             'productRef'    => 'string',
                             'productQty'    => 'int',
                             'productAmount' => 'string',
                             'productVat'    => 'string'],
                            $data);
    }
}