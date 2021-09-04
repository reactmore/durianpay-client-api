<?php

namespace Reactmore\Durianpay\Services;

use Exception;
use Reactmore\Durianpay\Helpers\Formats\ResponseFormatter;
use Reactmore\Durianpay\Helpers\Formats\Url;
use Reactmore\Durianpay\Helpers\Request\Guzzle;
use Reactmore\Durianpay\Helpers\Request\RequestFormatter;
use Reactmore\Durianpay\Helpers\Validations\MainValidator;

class Orders
{
    private  $api_url, $headers;

    public function __construct($credential, $stage)
    {

        $this->api_url = Url::URL_API[$stage];

        $this->headers = [
            "Authorization" =>  'Basic ' . base64_encode($credential['apikey'] . ':'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    public function createOrder($request = [])
    {
        try {
            MainValidator::validateRequest($request, ['amount', 'currency', 'customer']);

            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $response = Guzzle::sendRequest($this->api_url . '/orders', 'POST', $this->headers, $request);

            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function getOrders($request = [])
    {
        try {
            MainValidator::validateRequest($request);
            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $response = Guzzle::sendRequest($this->api_url . '/orders', 'GET', $this->headers, $request);

            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function getOrderById($request = [])
    {
        try {

            MainValidator::validateRequest($request, ['id']);
            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);
            $response = Guzzle::sendRequest($this->api_url . '/orders/' . $request['id'], 'GET', $this->headers);

            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function createInstaPay($request = [])
    {
        try {
            MainValidator::validateRequest($request, ['amount', 'currency', 'customer', 'is_payment_link']);

            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $response = Guzzle::sendRequest($this->api_url . '/orders', 'POST', $this->headers, $request);

            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }
}
