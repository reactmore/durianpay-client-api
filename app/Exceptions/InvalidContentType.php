<?php

namespace Reactmore\Durianpay\Exceptions;

class InvalidContentType extends BaseException
{
    public function setMessage()
    {
        return 'Content type must be array';
    }
}
