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
