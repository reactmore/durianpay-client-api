<?php

namespace Reactmore\Durianpay\Helpers\Validations;

class MainValidator
{
    public static function validateRequest($request, $required = [])
    {
        ValidationHelper::validateContentType($request);

        if (!empty($required)) {
            ValidationHelper::validateContentFields($request, $required);
        }
    }


    public static function validateCredentialRequest($request)
    {
        ValidationHelper::validateContentType($request);
        ValidationHelper::validateContentFields($request, ['code']);
    }
}
