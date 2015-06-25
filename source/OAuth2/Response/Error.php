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
