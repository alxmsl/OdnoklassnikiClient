<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace alxmsl\Odnoklassniki\OAuth2;

use alxmsl\Network\Http\Request;
use alxmsl\Odnoklassniki\OAuth2\Response\Error;
use alxmsl\Odnoklassniki\OAuth2\Response\ResponseFactory;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;

/**
 * Odnoklassniki OAuth client
 * @author alxmsl
 * @date 8/12/13
 */ 
class Client {
    /**
     * Response type constants
     */
    const RESPONSE_TYPE_CODE = 'code';

    /**
     * Available grant type constants
     */
    const GRANT_TYPE_AUTHORIZATION_CODE = 'authorization_code',
          GRANT_TYPE_REFRESH_TOKEN      = 'refresh_token';

    /**
     * Available scope constants
     */
    const SCOPE_VALUABLE_ACCESS = 'VALUABLE ACCESS',
          SCOPE_SET_STATUS      = 'SET STATUS',
          SCOPE_PHOTO_CONTENT   = 'PHOTO CONTENT';

    /**
     * OK API endpoints
     */
    const ENDPOINT_AUTHORIZE_REQUEST = 'http://www.odnoklassniki.ru/oauth/authorize',
          ENDPOINT_TOKEN_REQUEST     = 'http://api.odnoklassniki.ru/oauth/token.do';

    /**
     * Mobile authorization page layout constant
     */
    const LAYOUT_MOBILE = 'm';

    /**
     * @var string client identifier
     */
    private $clientId = '';

    /**
     * @var string client secret
     */
    private $clientSecret = '';

    /**
     * @var string redirect uri
     */
    private $redirectUri = '';

    /**
     * @var int connect timeout, seconds
     */
    private $connectTimeout = 0;

    /**
     * @var int request timeout, seconds
     */
    private $requestTimeout = 0;

    /**
     * Getter for the request
     * @param string $url request url
     * @return Request request object
     */
    protected function getRequest($url) {
        $Request = new Request();
        $Request->setTransport(Request::TRANSPORT_CURL);
        return $Request->setUrl($url)
            ->setConnectTimeout($this->getConnectTimeout())
            ->setTimeout($this->getRequestTimeout());
    }

    /**
     * Create authorization url
     * @param array $scopes needed scopes
     * @param string $needMobileView need to show authorization page for mobile view
     * @return string authorization url
     */
    public function createAuthUrl(array $scopes, $needMobileView = false) {
        $parameters = array(
            'client_id='     . $this->getClientId(),
            'response_type=' . self::RESPONSE_TYPE_CODE,
            'redirect_uri='  . $this->getRedirectUri(),
            'scope='         . implode(';', $scopes),
        );
        if ($needMobileView) {
            $parameters[] = 'layout=' . self::LAYOUT_MOBILE;
        }
        return self::ENDPOINT_AUTHORIZE_REQUEST . '?' . implode('&', $parameters);
    }

    /**
     * Get access token by user authorization code
     * @param string $code user authorization code
     * @return Token|Error token or error instance
     */
    public function authorize($code) {
        $Request = $this->getRequest(self::ENDPOINT_TOKEN_REQUEST);
        $Request->addPostField('code', $code)
            ->addPostField('redirect_uri', $this->getRedirectUri())
            ->addPostField('grant_type', self::GRANT_TYPE_AUTHORIZATION_CODE)
            ->addPostField('client_id', $this->getClientId())
            ->addPostField('client_secret', $this->getClientSecret());
        return ResponseFactory::createResponse($Request->send());
    }

    /**
     * Get access token by refresh token
     * @param string $refreshToken refresh token value
     * @return Token|Error token or error instance
     */
    public function refresh($refreshToken) {
        $Request = $this->getRequest(self::ENDPOINT_TOKEN_REQUEST);
        $Request->addPostField('refresh_token', $refreshToken)
            ->addPostField('grant_type', self::GRANT_TYPE_REFRESH_TOKEN)
            ->addPostField('client_id', $this->getClientId())
            ->addPostField('client_secret', $this->getClientSecret());
        return ResponseFactory::createResponse($Request->send());
    }

    /**
     * Setter for client identifier
     * @param string $clientId client identifier
     * @return Client self
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * Client identifier getter
     * @return string client identifier getter
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * Setter for client secret code
     * @param string $clientSecret client secret code
     * @return Client self
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * Getter for client secret code
     * @return string client secret code
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * Setter for redirect uri
     * @param string $redirectUri redirect uri setter
     * @return Client self
     */
    public function setRedirectUri($redirectUri) {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    /**
     * Getter for redirect uri
     * @return string redirect uri
     */
    public function getRedirectUri() {
        return $this->redirectUri;
    }

    /**
     * Setter for connect timeout value
     * @param int $connectTimeout connect timeout, seconds
     * @return Client self
     */
    public function setConnectTimeout($connectTimeout) {
        $this->connectTimeout = (int) $connectTimeout;
        return $this;
    }

    /**
     * Getter for connect timeout value
     * @return int connect timeout, seconds
     */
    public function getConnectTimeout() {
        return $this->connectTimeout;
    }

    /**
     * Setter for request timeout value
     * @param int $requestTimeout request timeout, seconds
     * @return Client self
     */
    public function setRequestTimeout($requestTimeout) {
        $this->requestTimeout = (int) $requestTimeout;
        return $this;
    }

    /**
     * Getter for request timeout value
     * @return int request timeout, seconds
     */
    public function getRequestTimeout() {
        return $this->requestTimeout;
    }
}
