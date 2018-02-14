<?php
namespace ElGigi\SystemPay\model;

/**
 * Class CommonRequest
 *
 * @package SystemPay\Model
 *
 * @property string $paymentSource  Payment source
 * @property string $submissionDate Submission date time
 * @property string $contractNumber Contract number
 * @property string $comment        Comment
 */
class CommonRequest extends Object
{
    /**
     * CommonRequest constructor.
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