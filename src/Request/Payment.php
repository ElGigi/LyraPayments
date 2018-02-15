<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Payment.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $amount              Payment amount
 * @property string $currency            Payment currency
 * @property string $expectedCaptureDate Payment expected capture date
 * @property string $manualValidation    Manual validation
 */
class Payment extends AbstractObject
{
    /**
     * Payment constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['amount'              => 'n..12',
                             'currency'            => 'n3',
                             'expectedCaptureDate' => 'datetime',
                             'manualValidation'    => 'n1'],
                            $data);
    }
}