<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request ExtendedResponse.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $isNsuRequested If need extended response
 */
class ExtendedResponse extends AbstractObject
{
    /**
     * ExtendedResponse constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['isNsuRequested' => 'n1'], $data);
    }
}