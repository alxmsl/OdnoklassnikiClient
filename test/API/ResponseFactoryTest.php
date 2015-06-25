<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Test\Odnoklassniki\API;

use alxmsl\Odnoklassniki\API\Response\Error;
use alxmsl\Odnoklassniki\API\Response\ResponseFactory;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Response factory test class
 * @author alxmsl
 */
final class ResponseFactoryTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Response1 = ResponseFactory::createResponse('{
            "error_code": 10,
            "error_msg": "Some error message",
            "error_data": "data"
        }');
        $this->assertInstanceOf(Error::class, $Response1);
        $this->assertEquals(Error::CODE_PERMISSION_DENIED, $Response1->getCode());
        $this->assertFalse($Response1->isSessionExpired());
        $this->assertEquals('Some error message', $Response1->getMessage());
        $this->assertEquals('data', $Response1->getData());

        $Response2 = ResponseFactory::createResponse('{
            "error_code": 102,
            "error_msg": "Some error message",
            "error_data": "data"
        }');
        $this->assertInstanceOf(Error::class, $Response2);
        $this->assertEquals(Error::CODE_PARAM_SESSION_EXPIRED, $Response2->getCode());
        $this->assertTrue($Response2->isSessionExpired());
        $this->assertEquals('Some error message', $Response2->getMessage());
        $this->assertEquals('data', $Response2->getData());

        $Response3 = ResponseFactory::createResponse('[
{"uid":"AAA","first_name":"First name","last_name":"Last name","gender":"male","location":{"country":"latvia","city":"Riga"},
"current_location":{"latitude":45.0,"longitude":-45.0},"current_status":"My Status ","pic_1":"photo 1","pic_2":"photo 2", "last_online":"2013-07-25 15:13:29"},
{"uid":"BBB","first_name":"First name","last_name":"Last name"}
]');
        $this->assertCount(2, $Response3);
        $this->assertInstanceOf(stdClass::class, $Response3[0]);
        $this->assertInstanceOf(stdClass::class, $Response3[1]);
        $this->assertEquals('AAA', $Response3[0]->uid);
        $this->assertEquals('First name', $Response3[0]->first_name);

        $this->assertInstanceOf(stdClass::class, $Response3[0]->location);
        $this->assertEquals('latvia', $Response3[0]->location->country);

        $this->assertEquals('BBB', $Response3[1]->uid);
        $this->assertEquals('Last name', $Response3[1]->last_name);
    }
}
