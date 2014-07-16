<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Odnoklassniki API example
 * @author alxmsl
 * @date 8/13/13
 */

include('../source/Autoloader.php');
include '../vendor/alxmsl/network/source/Autoloader.php';

use alxmsl\Odnoklassniki\OAuth\Response\Token;
use alxmsl\Odnoklassniki\API\Client;

// Create authorization token instance
$Token = new Token();
$Token->setAccessToken('4cCE5s_T0KEn')
    ->setRefreshToken('ReFRE5H_t0Ken')
    ->setTokenType(Token::TYPE_SESSION);

// Create and initialize OK API client instance
$Client = new Client();
$Client->setApplicationKey('4Pp1IC4t10n_KEy')
    ->setToken($Token)
    ->setClientId(1234567890)
    ->setClientSecret('C11eNt_SEcREt');

// Check if current user has current application
$Result = $Client->callConfidence('users.isAppUser');
var_dump($Result);

// Get current user info
$Result = $Client->callConfidence('users.getCurrentUser');
var_dump($Result);

// Get current user big size avatar
$Result = $Client->callConfidence('users.getInfo', array(
    'uids'   => 1,
    'fields' => 'pic_4',
));
var_dump($Result);

// Get user photos
$Result = $Client->callConfidence('photos.getPhotos');
var_dump($Result);
