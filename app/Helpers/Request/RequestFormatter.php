<?php

namespace Reactmore\Durianpay\Helpers\Request;

use Reactmore\Durianpay\Helpers\Formats\StringFormatter;

class RequestFormatter
{
    public static function formatArrayKeysToSnakeCase($arr)
    {
        foreach ($arr as $key => $value) {
            unset($arr[$key]);
            $arr[StringFormatter::convertCamelCaseToSnakeCase($key)] = $value;
        }

        return $arr;
    }
}
