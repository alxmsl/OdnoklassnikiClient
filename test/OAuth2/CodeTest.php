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
