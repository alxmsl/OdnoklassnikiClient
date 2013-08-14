<?php
/**
 * Odnoklassniki OAuth example
 * @author alxmsl
 * @date 8/12/13
 */

include('../source/Autoloader.php');
include '../lib/Network/source/Autoloader.php';

// Create and initialize OAuth client
$Client = new Odnoklassniki\Client\OAuth\Client();
$Client->setClientId(1234567890)
    ->setClientSecret('C11eNt_SEcREt')
    ->setRedirectUri('http://redirect.uri');

// Get authorization url
$url = $Client->createAuthUrl(array(
    \Odnoklassniki\Client\OAuth\Client::SCOPE_VALUABLE_ACCESS,
    \Odnoklassniki\Client\OAuth\Client::SCOPE_SET_STATUS,
    \Odnoklassniki\Client\OAuth\Client::SCOPE_PHOTO_CONTENT,
), true);
var_dump($url);

// Get authorization token instance by authoprization code
$Token = $Client->authorize('aUTH0R1zAt10N_c0dE');
var_dump($Token);

// Get new authorization token by refresh token
$Token = $Client->refresh('ReFRE5H_t0Ken');
var_dump($Token);