<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Script for Odnoklassniki API access token refreshing
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Odnoklassniki\OAuth\Client;
use alxmsl\Odnoklassniki\OAuth\Response\Token;

$clientId     = '';
$clientSecret = '';
$redirectUri  = '';
$refreshToken = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('client', 'c', 'client id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientId) {
        $clientId = $value;
    });
$Command->appendParameter(new Option('redirect', 'r', 'redirect uri', Option::TYPE_STRING, true)
    , function($name, $value) use (&$redirectUri) {
        $redirectUri = $value;
    });
$Command->appendParameter(new Option('token', 't', 'refresh token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$refreshToken) {
        $refreshToken = $value;
    });
$Command->appendParameter(new Option('secret', 's', 'client secret', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientSecret) {
        $clientSecret = $value;
    });

try {
    $Command->parse(true);

    $Client = new Client();
    $Client->setClientId($clientId)
        ->setClientSecret($clientSecret)
        ->setRedirectUri($redirectUri);

    $Token = $Client->refresh($refreshToken);
    if ($Token instanceof Token) {
        printf("%s\n", (string) $Token);
    } else {
        var_dump($Token);
    }
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
