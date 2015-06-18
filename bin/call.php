<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Script for Odnoklassniki API methods call
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Odnoklassniki\API\Client;
use alxmsl\Odnoklassniki\OAuth\Response\Token;

$accessToken    = '';
$applicationKey = '';
$clientId       = '';
$clientSecret   = '';
$methodName     = '';
$methodData     = '';

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('client', 'c', 'client id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientId) {
        $clientId = $value;
    });
$Command->appendParameter(new Option('data', 'd', 'API method parameters', Option::TYPE_STRING, true)
    , function($name, $value) use (&$methodData) {
        $methodData = json_decode($value, true);
    });
$Command->appendParameter(new Option('key', 'k', 'application key', Option::TYPE_STRING, true)
    , function($name, $value) use (&$applicationKey) {
        $applicationKey = $value;
    });
$Command->appendParameter(new Option('method', 'm', 'API method name', Option::TYPE_STRING, true)
    , function($name, $value) use (&$methodName) {
        $methodName = $value;
    });
$Command->appendParameter(new Option('secret', 's', 'client secret', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientSecret) {
        $clientSecret = $value;
    });
$Command->appendParameter(new Option('token', 't', 'access token', Option::TYPE_STRING, true)
    , function($name, $value) use (&$accessToken) {
        $accessToken = $value;
    });

try {
    $Command->parse(true);

    $Token = new Token();
    $Token->setAccessToken($accessToken)
        ->setTokenType(Token::TYPE_SESSION);

    $Client = new Client();
    $Client->setApplicationKey($applicationKey)
        ->setToken($Token)
        ->setClientId($clientId)
        ->setClientSecret($clientSecret);

    $Result = $Client->call($methodName, $methodData);
    print_r($Result);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
