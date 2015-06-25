<?php

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
