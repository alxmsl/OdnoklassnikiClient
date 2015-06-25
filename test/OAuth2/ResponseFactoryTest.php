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
