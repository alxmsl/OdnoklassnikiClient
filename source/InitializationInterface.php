<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

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
