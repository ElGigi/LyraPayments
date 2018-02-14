<?php
namespace ElGigi\SystemPay\model;

/**
 * Class ExtraDetails
 *
 * @package SystemPay\Model
 *
 * @property string $ipAddress     IP address
 * @property string $fingerPrintId Unique session id
 */
class ExtraDetails extends Object
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