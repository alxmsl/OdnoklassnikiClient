<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Odnoklassniki\OAuth2\Response;

use alxmsl\Odnoklassniki\InitializationInterface;
use alxmsl\Odnoklassniki\ObjectInitializedInterface;
use stdClass;

/**
 * Odnoklassnii OAuth error
 * @author alxmsl
 * @date 8/12/13
 */ 
final class Error implements InitializationInterface, ObjectInitializedInterface {
    /**
     * @var string authorization error
     */
    private $error = '';

    /**
     * @var string authorization error description
     */
    private $description = '';

    private function __construct() {}

    /**
     * Setter for authorization error description
     * @param string $description authorization error description
     * @return Error self
     */
    public function setDescription($description) {
        $this->description = (string) $description;
        return $this;
    }

    /**
     * Authorization error description getter
     * @return string authorization error description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Setter for authorization error code
     * @param string $error error code
     * @return Error self
     */
    public function setError($error) {
        $this->error = (string) $error;
        return $this;
    }

    /**
     * Authorization error code getter
     * @return string error code
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Method for object initialization by the string
     * @param string $string response string with authorization code data
     * @return Error response object
     */
    public static function initializeByString($string) {
        $data = array();
        parse_str($string, $data);
        $Error = new self();
        $Error->setError($data['error'])
            ->setDescription($data['error_description']);
        return $Error;
    }

    /**
     * Initialization method
     * @param stdClass $Object object for initialization
     * @return Error initialized object
     */
    public static function initializeByObject(stdClass $Object) {
        $Error = new self();
        if (isset($Object->error)) {
            $Error->setError($Object->error);
        }
        if (isset($Object->error_description)) {
            $Error->setDescription($Object->error_description);
        }
        return $Error;
    }
}
