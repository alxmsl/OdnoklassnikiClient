<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
