<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
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
