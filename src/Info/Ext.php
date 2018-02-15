<?php

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