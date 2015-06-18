<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Get authorization code for Odnoklassniki OAuth
 * @author alxmsl
 * @date 8/12/13
 */

include '../vendor/autoload.php';

use alxmsl\Odnoklassniki\OAuth2\Client;

// Create and initialize OAuth client
$Client = new Client();
$Client->setClientId(1234567890)
    ->setRedirectUri('http://redirect.uri');

// Get authorization url
$url = $Client->createAuthUrl([
    Client::SCOPE_VALUABLE_ACCESS,
    Client::SCOPE_SET_STATUS,
    Client::SCOPE_PHOTO_CONTENT,
], true);
printf("%s\n", $url);
