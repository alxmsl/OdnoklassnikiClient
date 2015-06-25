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

namespace alxmsl\Odnoklassniki\OAuth2\Response;

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
