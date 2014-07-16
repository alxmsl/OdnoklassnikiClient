<?php

namespace alxmsl\Odnoklassniki\API\Response;
use stdClass;

/**
 * Odnoklassniki API response factory
 * @author alxmsl
 * @date 8/12/13
 */ 
final class ResponseFactory {
    /**
     * Create OK OAuth response instance
     * @param string $string response data
     * @return Error|stdClass response instance
     */
    public static function createResponse($string) {
        $Object = json_decode($string);
        if (isset($Object->error_code)) {
            return Error::initializeByObject($Object);
        } else {
            return $Object;
        }
    }
}
