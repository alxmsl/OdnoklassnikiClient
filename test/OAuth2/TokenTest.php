<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Odnoklassniki\OAuth2;

use alxmsl\Odnoklassniki\OAuth2\Response\Token;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Token class test
 * @author alxmsl
 */
final class TokenTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Token = new Token();
        $this->assertEmpty($Token->getAccessToken());
        $this->assertEmpty($Token->getRefreshToken());
        $this->assertFalse($Token->hasRefreshToken());
        $this->assertEquals(Token::TYPE_NONE, $Token->getTokenType());
    }

    public function testProperties() {
        $Token = new Token();
        $Token->setAccessToken('accesssss_tokkken');
        $this->assertEquals('accesssss_tokkken', $Token->getAccessToken());

        $Token->setRefreshToken('someREFREshTOken');
        $this->assertEquals('someREFREshTOken', $Token->getRefreshToken());
        $this->assertTrue($Token->hasRefreshToken());

        $Token->setTokenType(Token::TYPE_SESSION);
        $this->assertEquals(Token::TYPE_SESSION, $Token->getTokenType());
    }

    public function testObjectInitialization() {
        $Token1 = Token::initializeByObject(new stdClass());
        $this->assertEmpty($Token1->getAccessToken());
        $this->assertEmpty($Token1->getRefreshToken());
        $this->assertFalse($Token1->hasRefreshToken());
        $this->assertEquals(Token::TYPE_NONE, $Token1->getTokenType());

        $Object2 = new stdClass();
        $Object2->access_token  = 'accesssss_tokkken';
        $Object2->refresh_token = 'someREFREshTOken';
        $Object2->token_type    = 'bearer';
        $Token2 = Token::initializeByObject($Object2);
        $this->assertEquals('accesssss_tokkken', $Token2->getAccessToken());
        $this->assertEquals('someREFREshTOken', $Token2->getRefreshToken());
        $this->assertTrue($Token2->hasRefreshToken());
        $this->assertEquals('bearer', $Token2->getTokenType());
    }

    public function testMerge() {
        $Token1 = Token::initializeByObject(new stdClass());
        $Token2 = new Token();
        $Token2->setAccessToken('accesssss_tokkken');
        $Token2->setRefreshToken('someREFREshTOken');
        $Token2->setTokenType(Token::TYPE_SESSION);

        $this->assertEmpty($Token1->getAccessToken());
        $this->assertEmpty($Token1->getRefreshToken());
        $this->assertFalse($Token1->hasRefreshToken());
        $this->assertEquals(Token::TYPE_NONE, $Token1->getTokenType());
        $Token1->merge($Token2);
        $this->assertEquals('accesssss_tokkken', $Token1->getAccessToken());
        $this->assertEmpty($Token1->getRefreshToken());
        $this->assertFalse($Token1->hasRefreshToken());
        $this->assertEquals(Token::TYPE_SESSION, $Token1->getTokenType());
    }
}
