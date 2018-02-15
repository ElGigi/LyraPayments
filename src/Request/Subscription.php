<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Subscription.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $effectDate          Effect date
 * @property string $amount              Amount
 * @property string $currency            Currency
 * @property string $initialAmount       Initial amount
 * @property string $initialAmountNumber Initial amount number
 * @property string $rrule               Rules
 * @property string $subscriptionId      Subscription id
 * @property string $description         Description
 */
class Subscription extends AbstractObject
{
    /**
     * Subscription constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['effectDate'          => 'datetime',
                             'amount'              => 'n..12',
                             'currency'            => 'n3',
                             'initialAmount'       => 'n..12',
                             'initialAmountNumber' => 'int',
                             'rrule'               => 'string',
                             'subscriptionId'      => 'string',
                             'description'         => 'string'],
                            $data);
    }
}