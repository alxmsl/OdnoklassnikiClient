<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Odnoklassniki;

// append autoloader
spl_autoload_register(array('\alxmsl\Odnoklassniki\Autoloader', 'autoload'));

/**
 * Odnoklassniki REST API Client classes autoloader
 * @author alxmsl
 * @date 8/9/13
 */
final class Autoloader {
    /**
     * @var array array of available classes
     */
    private static $classes = array(
        'alxmsl\\Odnoklassniki\\Autoloader'                 => 'Autoloader.php',
        'alxmsl\\Odnoklassniki\\InitializationInterface'    => 'InitializationInterface.php',
        'alxmsl\\Odnoklassniki\\ObjectInitializedInterface' => 'ObjectInitializedInterface.php',

        'alxmsl\\Odnoklassniki\\OAuth\\Client'                    => 'OAuth/Client.php',
        'alxmsl\\Odnoklassniki\\OAuth\\Response\\Code'            => 'OAuth/Response/Code.php',
        'alxmsl\\Odnoklassniki\\OAuth\\Response\\Error'           => 'OAuth/Response/Error.php',
        'alxmsl\\Odnoklassniki\\OAuth\\Response\\ResponseFactory' => 'OAuth/Response/ResponseFactory.php',
        'alxmsl\\Odnoklassniki\\OAuth\\Response\\Token'           => 'OAuth/Response/Token.php',

        'alxmsl\\Odnoklassniki\\API\\Client'                    => 'API/Client.php',
        'alxmsl\\Odnoklassniki\\API\\Response\\Error'           => 'API/Response/Error.php',
        'alxmsl\\Odnoklassniki\\API\\Response\\ResponseFactory' => 'API/Response/ResponseFactory.php',

        'alxmsl\\Odnoklassniki\\API\\Exception\\ClientException'             => 'API/Exception/ClientException.php',
        'alxmsl\\Odnoklassniki\\API\\Exception\\RefreshTokenExpireException' => 'API/Exception/RefreshTokenExpireException.php',
        'alxmsl\\Odnoklassniki\\API\\Exception\\UnknownClientErrorException' => 'API/Exception/UnknownClientErrorException.php',
    );

    /**
     * Component autoloader
     * @param string $className claass name
     */
    public static function autoload($className) {
        if (array_key_exists($className, self::$classes)) {
            $fileName = realpath(dirname(__FILE__)) . '/' . self::$classes[$className];
            if (file_exists($fileName)) {
                include $fileName;
            }
        }
    }
}
