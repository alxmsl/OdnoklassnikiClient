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
