<?php

namespace Odnoklassniki\Client\API;

use Odnoklassniki\Client\API\Response\Error;
use Odnoklassniki\Client\API\Response\ResponseFactory;
use Odnoklassniki\Client\OAuth\Response\Token;
use Odnoklassniki\Client\OAuth\Client as OAuthClient;

/**
 * Odnoklassniki API client
 * @author alxmsl
 * @date 8/13/13
 */ 
final class Client extends OAuthClient {
    /**
     * API endpoint constants
     */
    const   ENDPOINT_API_URL = 'http://api.odnoklassniki.ru',
            ENDPOINT_API_GET = 'http://api.odnoklassniki.ru/fb.do';

    /**
     * API requests types constants
     */
    const   TYPE_GET = 0,   // for queries over fb.do
            TYPE_URL = 1;   // for queries over method resource

    /**
     * @var int static queries counter
     */
    private static $counter = 0;

    /**
     * @var Token|null authorization token instance
     */
    private $Token = null;

    /**
     * @var string application key
     */
    private $applicationKey = '';

    /**
     * @var int request type
     */
    private $type = self::TYPE_GET;

    /**
     * Authorization token setter
     * @param Token $Token authorization token instance
     * @return Client self
     */
    public function setToken(Token $Token) {
        $this->Token = $Token;
        return $this;
    }

    /**
     * Authorization token getter
     * @return Token authorization token instance
     */
    public function getToken() {
        return $this->Token;
    }

    /**
     * Application key setter
     * @param string $applicationKey application key
     * @return Client self
     */
    public function setApplicationKey($applicationKey) {
        $this->applicationKey = (string) $applicationKey;
        return $this;
    }

    /**
     * Application key getter
     * @return string application key
     */
    public function getApplicationKey() {
        return $this->applicationKey;
    }

    /**
     * Request type setter
     * @param int $type request type
     * @return Client self
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Request type getter
     * @return int request type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Confidence method call. Method tries to get new access token, if needed
     * @param string $method method name
     * @param array $parameters call parameters
     * @return Error|\stdClass error or result instance
     */
    public function callConfidence($method, array $parameters = array()) {
        $Result = $this->call($method, $parameters);
        if ($Result instanceof Error
            && $Result->isSessionExpired()) {

            $this->refreshToken();
            $Result = $this->call($method, $parameters);
        }
        return $Result;
    }

    /**
     * Direct method call
     * @param string $method method name
     * @param array $parameters call parameters
     * @return Error|\stdClass error or result instance
     */
    public function call($method, array $parameters = array()) {
        $data = $this->getParameters($method, $parameters);

        $signature = $this->getSignature($data);
        $data['sig'] = $signature;
        $data['access_token'] = $this->getToken()->getAccessToken();

        $Request = $this->getMethodRequest($method);
        foreach ($data as $key => $value) {
            $Request->addPostField($key, $value);
        }
        return ResponseFactory::createResponse($Request->send());
    }

    /**
     * Override method for request creation
     * @param string $method OK API method name
     * @return \Network\Http\Request request instance
     */
    protected function getMethodRequest($method) {
        switch ($this->getType()) {
            case self::TYPE_URL:
                $url = self::ENDPOINT_API_URL . '/api/' . str_replace('.', '/', $method);
                break;
            case self::TYPE_GET:
            default:
                $url = self::ENDPOINT_API_GET;
                break;
        }
        return parent::getRequest($url);
    }

    /**
     * Request parameters getter
     * @param string $method OK API method name
     * @param array $parameters request parameters
     * @return array extended request parameters for OK API query
     */
    private function getParameters($method, array $parameters) {
        $result = $parameters + array(
            'application_key'   => $this->getApplicationKey(),
            'call_id'           => $this->getCallId(),
        );

        if ($this->getType() == self::TYPE_GET) {
            $result['method'] = $method;
        }
        return $result;
    }

    /**
     * Request parameters sign method
     * @param array $parameters request parameters
     * @return string request parameters signature
     */
    private function getSignature(array $parameters) {
        ksort($parameters);
        $signature = '';
        foreach ($parameters as $parameter => $value) {
            $signature .= $parameter . '=' . $value;
        }
        return md5($signature . md5($this->getToken()->getAccessToken() . $this->getClientSecret()));
    }

    /**
     * Call identifier getter
     * @return int call identifier
     */
    private function getCallId() {
        return ++self::$counter;
    }

    /**
     * Refresh current token method
     * @throws RefreshTokenExpireException|UnknownClientErrorException
     */
    private function refreshToken() {
        $ExpiredToken = $this->getToken();
        $Token = $this->refresh($ExpiredToken->getRefreshToken());
        switch (true) {
            case $Token instanceof Token:
                $this->setToken($ExpiredToken->merge($Token));
                break;
            default:
                /** @var \Odnoklassniki\Client\OAuth\Response\Error $Error */
                $Error = $Token;
                throw ($Error->getError() == 'access_denied')
                    ? new RefreshTokenExpireException()
                    : new UnknownClientErrorException();
        }
    }
}

/**
 * Base Odnoklassniki client exception
 * @package Odnoklassniki\Client\API
 */
class ClientException extends \Exception {}

/**
 * Unknown Odnoklassniki API client exception
 * @package Odnoklassniki\Client\API
 */
final class UnknownClientErrorException extends ClientException {}

/**
 * Expired Odnoklassniki refresh token exception
 * @package Odnoklassniki\Client\API
 */
final class RefreshTokenExpireException extends ClientException {}