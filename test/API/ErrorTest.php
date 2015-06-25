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
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Error tests class
 * @author alxmsl
 */
final class ErrorTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Object1 = new stdClass();
        $Object1->error_code = Error::CODE_ACTION_BLOCKED;
        $Object1->error_msg = 'Some error message';
        $Object1->error_data = 'data';
        $Error1 = Error::initializeByObject($Object1);
        $this->assertEquals(Error::CODE_ACTION_BLOCKED, $Error1->getCode());
        $this->assertFalse($Error1->isSessionExpired());
        $this->assertEquals('Some error message', $Error1->getMessage());
        $this->assertEquals('data', $Error1->getData());

        $Object2 = new stdClass();
        $Object2->error_code = Error::CODE_PARAM_SESSION_EXPIRED;
        $Object2->error_msg = 'Some error message';
        $Object2->error_data = 'data';
        $Error2 = Error::initializeByObject($Object2);
        $this->assertEquals(Error::CODE_PARAM_SESSION_EXPIRED, $Error2->getCode());
        $this->assertTrue($Error2->isSessionExpired());
        $this->assertEquals('Some error message', $Error2->getMessage());
        $this->assertEquals('data', $Error2->getData());
    }
}
