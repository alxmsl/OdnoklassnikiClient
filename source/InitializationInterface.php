<?php

namespace alxmsl\Odnoklassniki;

/**
 * Interface for self-initialization objects
 * @author alxmsl
 * @date 2/9/13
 */
interface InitializationInterface {
    /**
     * Initialization method
     * @param string $string data for object initialization
     * @return InitializationInterface initialized object
     */
    public static function initializeByString($string);
}
