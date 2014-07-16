<?php

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
