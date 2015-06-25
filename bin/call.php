<?php
/**
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Script for Odnoklassniki API methods call
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Odnoklassniki\API\Client;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;

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
$Command->appendParameter(new Option('data', 'd', 'API method parameters (JSON)', Option::TYPE_STRING, true)
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
