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

use alxmsl\Odnoklassniki\OAuth2\Response\Error;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Error test class
 * @author alxmsl
 */
final class ErrorTest extends PHPUnit_Framework_TestCase {
    public function testStringInitialization() {
        $Error = Error::initializeByString('error=some_error&error_description=Some error description');
        $this->assertEquals('Some error description', $Error->getDescription());
        $this->assertEquals('some_error', $Error->getError());
    }

    public function testObjectInitialization() {
        $Error1 = Error::initializeByObject(new stdClass());
        $this->assertEmpty($Error1->getDescription());
        $this->assertEmpty($Error1->getError());

        $Object2 = new stdClass();
        $Object2->error_description = 'Some error description';
        $Object2->error = 'some_error';
        $Error2 = Error::initializeByObject($Object2);
        $this->assertEquals('Some error description', $Error2->getDescription());
        $this->assertEquals('some_error', $Error2->getError());
    }
}
