<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Odnoklassniki\OAuth2;

use alxmsl\Odnoklassniki\OAuth2\Response\Code;
use alxmsl\Odnoklassniki\OAuth2\Response\Error;
use alxmsl\Odnoklassniki\OAuth2\Response\ResponseFactory;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;
use PHPUnit_Framework_TestCase;

/**
 * OK API Response factory test class
 * @author alxmsl
 */
final class ResponseFactoryTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Response1 = ResponseFactory::createResponse('{
            "access_token": "kjdhfldjfhgldsjhfglkdjfg9ds8fg0sdf8gsd8fg",
            "token_type": "session",
            "refresh_token": "klsdjhf0e9dyfasduhfpasdfasdfjaspdkfjp"
        }');
        $this->assertInstanceOf(Token::class, $Response1);
        $this->assertEquals('kjdhfldjfhgldsjhfglkdjfg9ds8fg0sdf8gsd8fg', $Response1->getAccessToken());
        $this->assertEquals('klsdjhf0e9dyfasduhfpasdfasdfjaspdkfjp', $Response1->getRefreshToken());
        $this->assertTrue($Response1->hasRefreshToken());
        $this->assertEquals(Token::TYPE_SESSION, $Response1->getTokenType());

        $Response2 = ResponseFactory::createResponse('{
            "error": "some_error",
            "error_description": "Some error description"
        }');
        $this->assertInstanceOf(Error::class, $Response2);
        $this->assertEquals('some_error', $Response2->getError());
        $this->assertEquals('Some error description', $Response2->getDescription());

        $Response3 = ResponseFactory::createResponse('https://example.com/oauth2callback?error=some_error&error_description=Some error description');
        $this->assertInstanceOf(Error::class, $Response3);
        $this->assertEquals('some_error', $Response3->getError());
        $this->assertEquals('Some error description', $Response3->getDescription());

        $Response4 = ResponseFactory::createResponse('https://example.com/oauth2callback?code=someCode/1');
        $this->assertInstanceOf(Code::class, $Response4);
        $this->assertEquals('someCode/1', $Response4->getCode());
    }
}
