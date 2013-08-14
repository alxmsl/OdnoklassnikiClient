<?php

namespace Odnoklassniki\Client\OAuth\Response;
use Odnoklassniki\Client\ObjectInitializedInterface;

/**
 * Odnoklassniki authorization token
 * @author alxmsl
 * @date 8/12/13
 */ 
final class Token implements ObjectInitializedInterface {
    /**
     * Token types constants
     */
    const   TYPE_NONE = '',
            TYPE_SESSION = 'session';

    /**
     * @var string access token
     */
    private $accessToken = '';

    /**
     * @var string refresh token
     */
    private $refreshToken = '';

    /**
     * @var string token type
     */
    private $tokenType = self::TYPE_NONE;

    /**
     * Setter for access token
     * @param string $accessToken access token
     * @return Token self
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = (string) $accessToken;
        return $this;
    }

    /**
     * Getter for access token
     * @return string access token
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Setter for refresh token
     * @param string $refreshToken refresh token
     * @return Token self
     */
    public function setRefreshToken($refreshToken) {
        $this->refreshToken = (string) $refreshToken;
        return $this;
    }

    /**
     * Getter for refresh token
     * @return string refresh token
     */
    public function getRefreshToken() {
        return $this->refreshToken;
    }

    /**
     * Has token instance a refresh token value
     * @return bool has token instance a refresh token value
     */
    public function hasRefreshToken() {
        return !empty($this->refreshToken);
    }

    /**
     * Setter for token type
     * @param string $tokenType token type value
     * @return Token self
     */
    public function setTokenType($tokenType) {
        $this->tokenType = (string) $tokenType;
        return $this;
    }

    /**
     * Getter for token type
     * @return string token type value
     */
    public function getTokenType() {
        return $this->tokenType;
    }

    /**
     * Initialization method
     * @param \stdClass $Object object for initialization
     * @return ObjectInitializedInterface initialized object
     */
    public static function initializeByObject(\stdClass $Object) {
        $Token = new self();
        if (isset($Object->token_type)) {
            $Token->setTokenType($Object->token_type);
        }
        if (isset($Object->access_token)) {
            $Token->setAccessToken($Object->access_token);
        }
        if (isset($Object->refresh_token)) {
            $Token->setRefreshToken($Object->refresh_token);
        }
        return $Token;
    }

    /**
     * Merge token instances.
     * Apply access token and token type values for current token
     * Save refresh token value
     * @param Token $Token token instance
     * @return Token self
     */
    public function merge(Token $Token) {
        $this->setAccessToken($Token->getAccessToken())
            ->setTokenType($Token->getTokenType());
        return $this;
    }
}
