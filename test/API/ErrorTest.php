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
