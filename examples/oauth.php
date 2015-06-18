<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Odnoklassniki OAuth example
 * @author alxmsl
 * @date 8/12/13
 */

include '../vendor/autoload.php';

use alxmsl\Odnoklassniki\OAuth\Client;

// Create and initialize OAuth client
$Client = new Client();
$Client->setClientId(1234567890)
    ->setClientSecret('C11eNt_SEcREt')
    ->setRedirectUri('http://redirect.uri');

// Get authorization url
$url = $Client->createAuthUrl(array(
    Client::SCOPE_VALUABLE_ACCESS,
    Client::SCOPE_SET_STATUS,
    Client::SCOPE_PHOTO_CONTENT,
), true);
var_dump($url);

// Get authorization token instance by authoprization code
$Token = $Client->authorize('aUTH0R1zAt10N_c0dE');
var_dump($Token);

// Get new authorization token by refresh token
$Token = $Client->refresh('ReFRE5H_t0Ken');
var_dump($Token);
