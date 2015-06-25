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
 * Script for Odnoklassniki API access token refreshing
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Cli\Option;
use alxmsl\Odnoklassniki\OAuth2\Client;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;

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
