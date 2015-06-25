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
use PHPUnit_Framework_TestCase;

/**
 * Code test class
 * @author alxmsl
 */
final class CodeTest extends PHPUnit_Framework_TestCase {
    public function testInitialState() {
        $Code = new Code();
        $this->assertEmpty($Code->getCode());
    }

    public function testProperty() {
        $Code = new Code();
        $Code->setCode(0001);
        $this->assertSame('1', $Code->getCode());
    }

    public function testStringInitialization() {
        $Code = Code::initializeByString('code=someCode/1');
        $this->assertEquals('someCode/1', $Code->getCode());
    }
}
