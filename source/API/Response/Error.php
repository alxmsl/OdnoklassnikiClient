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

namespace alxmsl\Odnoklassniki\API\Response;

use alxmsl\Odnoklassniki\ObjectInitializedInterface;
use stdClass;

/**
 * Odnoklassniki API error
 * @author alxmsl
 * @date 8/12/13
 */ 
final class Error implements ObjectInitializedInterface {
    /**
     * Error constants
     */
    const CODE_UNKNOWN                     = 1,
          CODE_SERVICE                     = 2,
          CODE_METHOD                      = 3,
          CODE_REQUEST                     = 4,
          CODE_ACTION_BLOCKED              = 7,
          CODE_FLOOD_BLOCKED               = 8,
          CODE_IP_BLOCKED                  = 9,
          CODE_PERMISSION_DENIED           = 10,
          CODE_LIMIT_REACHED               = 11,
          CODE_NOT_MULTIPART               = 21,
          CODE_PARAM                       = 100,
          CODE_PARAM_API_KEY               = 101,
          CODE_PARAM_SESSION_EXPIRED       = 102,
          CODE_PARAM_SESSION_KEY           = 103,
          CODE_PARAM_SIGNATURE             = 104,
          CODE_PARAM_RESIGNATURE           = 105,
          CODE_PARAM_USER_ID               = 110,
          CODE_PARAM_ALBUM_ID              = 120,
          CODE_PARAM_WIDGET                = 130,
          CODE_PARAM_MESSAGE_ID            = 140,
          CODE_PARAM_PERMISSION            = 200,
          CODE_PARAM_APPLICATION_DISABLED  = 210,
          CODE_NOT_FOUND                   = 300,
          CODE_EDIT_PHOTO_FILE             = 324,
          CODE_AUTH_LOGIN                  = 401,
          CODE_AUTH_LOGIN_CAPTCHA          = 402,
          CODE_SESSION_REQUIRED            = 453,
          CODE_CENSOR_MATCH                = 454,
          CODE_FRIEND_RESTRICTION          = 455,
          CODE_PHOTO_SIZE_LIMIT_EXCEEDED   = 500,
          CODE_PHOTO_SIZE_TOO_SMALL        = 501,
          CODE_PHOTO_SIZE_TOO_BIG          = 502,
          CODE_PHOTO_INVALID_FORMAT        = 503,
          CODE_PHOTO_IMAGE_CORRUPTED       = 504,
          CODE_PHOTO_NO_IMAGE              = 505,
          CODE_NO_SUCH_APP                 = 900,
          CODE_SYSTEM                      = 9999,
          CODE_CALLBACK_INVALID_PAYMENT    = 1001,
          CODE_PAYMENT_IS_REQUIRED_PAYMENT = 1002,
          CODE_INVALID_PAYMENT             = 1003;

    /**
     * @var string error code
     */
    private $code = '';

    /**
     * @var string error description
     */
    private $message = '';

    /**
     * @var mixed error data
     */
    private $data = null;

    private function __construct() {}

    /**
     * Setter for error description
     * @param string $description error description
     * @return Error self
     */
    public function setMessage($description) {
        $this->message = (string) $description;
        return $this;
    }

    /**
     * Error description getter
     * @return string error description
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Setter for error code
     * @param string $error error code
     * @return Error self
     */
    public function setCode($error) {
        $this->code = (string) $error;
        return $this;
    }

    /**
     * Error code getter
     * @return string error code
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Error data setter
     * @param mixed|null $data error data instance
     * @return Error self
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * Error data getter
     * @return null|mixed error data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Initialization method
     * @param stdClass $Object object for initialization
     * @return Error initialized object
     */
    public static function initializeByObject(stdClass $Object) {
        $Error = new self();
        $Error->setCode($Object->error_code)
            ->setMessage($Object->error_msg)
            ->setData($Object->error_data);
        return $Error;
    }

    /**
     * Session expired error getter
     * @return bool session expired error or not
     */
    public function isSessionExpired() {
        return $this->code == self::CODE_PARAM_SESSION_EXPIRED;
    }
}
