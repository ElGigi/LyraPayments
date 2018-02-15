<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request ExtraDetails.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $ipAddress     IP address
 * @property string $fingerPrintId Unique session id
 */
class ExtraDetails extends AbstractObject
{
    /**
     * ExtraDetails constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['ipAddress'     => 'ans40',
                             'fingerPrintId' => 'ans128'],
                            $data);
    }
}