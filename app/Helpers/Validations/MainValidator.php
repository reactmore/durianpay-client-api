<?php

namespace Reactmore\Durian\Helpers\Validations;

class MainValidator
{
    public static function validateCredentialRequest($request)
    {
        ValidationHelper::validateContentType($request);
    }
}
