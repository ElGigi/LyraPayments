<?php

namespace ElGigi\SystemPay\Request;

use ElGigi\SystemPay\AbstractObject;

/**
 * Request Tech.
 *
 * @package ElGigi\SystemPay\Request
 *
 * @property string $browserUserAgent Browser user agent header value
 * @property string $browserAccept    Browser accept header value
 */
class Tech extends AbstractObject
{
    /**
     * Tech constructor.
     *
     * @param array $data Default data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(['browserUserAgent' => 'string',
                             'browserAccept'    => 'string'],
                            $data);
    }
}