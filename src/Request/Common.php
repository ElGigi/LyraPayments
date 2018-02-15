<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Common.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $paymentSource  Payment source
 * @property string $submissionDate Submission date time
 * @property string $contractNumber Contract number
 * @property string $comment        Comment
 */
class Common extends AbstractObject
{
    /**
     * Common constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['paymentSource'  => '[EC,MOTO,CC,OTHER]',
                             'submissionDate' => 'datetime',
                             'contractNumber' => 'string',
                             'comment'        => 'string'],
                            $data);
    }
}