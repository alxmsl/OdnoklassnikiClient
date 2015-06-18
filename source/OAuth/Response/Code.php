<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Odnoklassniki\OAuth\Response;

use alxmsl\Odnoklassniki\InitializationInterface;

/**
 * Odnoklassniki OAuth authorization code
 * @author alxmsl
 * @date 3/30/13
 */
final class Code implements InitializationInterface {
    /**
     * @var string authorization code
     */
    private $code = '';

    /**
     * Setter for authorization code
     * @param string $code authorization code
     * @return Code self
     */
    public function setCode($code) {
        $this->code = (string) $code;
        return $this;
    }

    /**
     * Getter for authorization code
     * @return string authorization code
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Method for object initialization by the string
     * @param string $string response string with authorization code data
     * @return Code response object
     */
    public static function initializeByString($string) {
        $data = array();
        parse_str($string, $data);
        $Response = new self();
        return $Response->setCode($data['code']);
    }
}
