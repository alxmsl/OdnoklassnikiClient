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

namespace alxmsl\Test\Odnoklassniki\API;

use alxmsl\Odnoklassniki\API\Client;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * Client tests class
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Client = new Client();
        $this->assertEmpty($Client->getApplicationKey());
        $this->assertNull($Client->getToken());
        $this->assertEquals(Client::TYPE_GET, $Client->getType());
    }

    public function testProperties() {
        $Client = new Client();

        $Client->setApplicationKey('4PpL1cat1ON_KEy');
        $this->assertEquals('4PpL1cat1ON_KEy', $Client->getApplicationKey());

        $Token = new Token();
        $Client->setToken($Token);
        $this->assertInstanceOf(Token::class, $Client->getToken());
        $this->assertEquals($Token, $Client->getToken());

        $Client->setType(Client::TYPE_GET);
        $this->assertEquals(Client::TYPE_GET, $Client->getType());

        $Client->setType(Client::TYPE_URL);
        $this->assertEquals(Client::TYPE_URL, $Client->getType());
    }

    public function testGetMethodRequest() {
        $Class = new ReflectionClass(Client::class);
        $Method = $Class->getMethod('getMethodRequest');
        $Method->setAccessible(true);

        $Client = new Client();
        $this->assertEquals('http://api.odnoklassniki.ru/fb.do', $Method->invoke($Client, 'users.getInfo')->getUrl());

        $Client->setType(Client::TYPE_URL);
        $this->assertEquals('http://api.odnoklassniki.ru/api/users/getInfo', $Method->invoke($Client, 'users.getInfo')->getUrl());
    }

    public function testGetParameters() {
        $Class = new ReflectionClass(Client::class);
        $Method = $Class->getMethod('getParameters');
        $Method->setAccessible(true);

        $Client = new Client();
        $Client->setApplicationKey('4PpL1cat1ON_KEy');
        $this->assertEquals([
            'aaa'             => 7,
            'application_key' => '4PpL1cat1ON_KEy',
            'bbb'             => 'opka',
            'call_id'         => 1,
            'method'          => 'users.getInfo',
        ], $Method->invoke($Client, 'users.getInfo', [
            'aaa' => 7,
            'bbb' => 'opka',
        ]));

        $Client->setType(Client::TYPE_URL);
        $this->assertEquals([
            'aaa'             => 7,
            'application_key' => '4PpL1cat1ON_KEy',
            'bbb'             => 'opka',
            'call_id'         => 2,
        ], $Method->invoke($Client, 'users.getInfo', [
            'aaa' => 7,
            'bbb' => 'opka',
        ]));
    }

    public function testGetSignature() {
        $Class = new ReflectionClass(Client::class);
        $Method = $Class->getMethod('getSignature');
        $Method->setAccessible(true);

        $Token = new Token();
        $Token->setAccessToken('accesssss_tokkken');

        $Client = new Client();
        $Client->setToken($Token)
            ->setClientSecret('ClienTSECRET');
        $this->assertEquals('01a36a2aa93eb052cbabc18febbaa992', $Method->invoke($Client, [
            'bbb' => 'opka',
            'aaa' => 7,
        ]));
    }
}
