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

/**
 * Odnoklassniki OAuth server responses factory
 * @author alxmsl
 * @date 8/12/13
 */ 
final class ResponseFactory {
    /**
     * Create OK OAuth response instance
     * @param string $string response data
     * @return Code|Token|Error response instance
     */
    public static function createResponse($string) {
        $Value = json_decode($string);
        if (json_last_error() === JSON_ERROR_NONE) {
            switch (true) {
                case isset($Value->error):
                    return Error::initializeByObject($Value);
                default:
                    return Token::initializeByObject($Value);
            }
        } else {
            $value = parse_url($string, PHP_URL_QUERY);
            switch (true) {
                case strpos($value, 'error=') === 0:
                    return Error::initializeByString($value);
                case strpos($value, 'code=') === 0:
                    return Code::initializeByString($value);
            }
        }
    }
}
