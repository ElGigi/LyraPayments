<?php
namespace SystemPay\model;

/**
 * Class ThreeDSRequest
 *
 * @package SystemPay\model
 *
 * @property string $mode      3DS mode
 * @property string $requestId Request id
 * @property string $pares     PaRes message
 * @property string $brand     Brand card
 * @property string $enrolled  Enrolment status
 * @property string $eci       E-commerce indicator
 * @property string $xid       3DS transaction id
 * @property string $cavv      ACS certificate
 * @property string $algorithm Algorithm
 */
class ThreeDSRequest extends Object
{
    /**
     * ThreeDSRequest constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['mode'      => '[DISABLED,ENABLED_CREATE,ENABLED_FINALIZE]',
                             'requestId' => 'string',
                             'pares'     => 'string',
                             'brand'     => 'string',
                             'enrolled'  => '[Y,N,U]',
                             'eci'       => 'string',
                             'xid'       => 'string',
                             'cavv'      => 'string',
                             'algorithm' => '[0,1,2,3]'],
                            $data);
    }
}