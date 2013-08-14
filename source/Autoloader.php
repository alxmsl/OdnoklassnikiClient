<?php

namespace Odnoklassniki\Client;

// append autoloader
spl_autoload_register(array('\Odnoklassniki\Client\Autoloader', 'Autoloader'));

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
        'Odnoklassniki\\Client\\Autoloader'                 => 'Autoloader.php',
        'Odnoklassniki\\Client\\InitializationInterface'    => 'InitializationInterface.php',
        'Odnoklassniki\\Client\\ObjectInitializedInterface' => 'ObjectInitializedInterface.php',

        'Odnoklassniki\\Client\\OAuth\\Client'                  => 'OAuth/Client.php',
        'Odnoklassniki\\Client\\OAuth\\Response\\Code'          => 'OAuth/Response/Code.php',
        'Odnoklassniki\\Client\\OAuth\\Response\\Error'         => 'OAuth/Response/Error.php',
        'Odnoklassniki\\Client\\OAuth\\Response\\ResponseFactory' => 'OAuth/Response/ResponseFactory.php',
        'Odnoklassniki\\Client\\OAuth\\Response\\Token'         => 'OAuth/Response/Token.php',

        'Odnoklassniki\\Client\\API\\Client'                    => 'API/Client.php',
        'Odnoklassniki\\Client\\API\\Response\\Error'           => 'API/Response/Error.php',
        'Odnoklassniki\\Client\\API\\Response\\ResponseFactory' => 'API/Response/ResponseFactory.php',
    );

    /**
     * Component autoloader
     * @param string $className claass name
     */
    public static function Autoloader($className) {
        if (array_key_exists($className, self::$classes)) {
            $fileName = realpath(dirname(__FILE__)) . '/' . self::$classes[$className];
            if (file_exists($fileName)) {
                include $fileName;
            }
        }
    }
}
