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
 * Script for Odnoklassniki API authorization
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
$code         = '';
$redirectUri  = '';
$scopes       = [];

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('code', 'o', 'authorization code', Option::TYPE_STRING)
    , function($name, $value) use (&$code) {
        $code = $value;
    });
$Command->appendParameter(new Option('client', 'c', 'client id', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientId) {
        $clientId = $value;
    });
$Command->appendParameter(new Option('redirect', 'r', 'redirect uri', Option::TYPE_STRING)
    , function($name, $value) use (&$redirectUri) {
        $redirectUri = $value;
    });
$Command->appendParameter(new Option('scopes', 's', 'grant scopes', Option::TYPE_STRING)
    , function($name, $value) use (&$scopes) {
        $scopes = explode(',', $value);
    });
$Command->appendParameter(new Option('secret', 'e', 'client secret', Option::TYPE_STRING, true)
    , function($name, $value) use (&$clientSecret) {
        $clientSecret = $value;
    });

try {
    $Command->parse(true);

    $Client = new Client();
    $Client->setClientId($clientId)
        ->setClientSecret($clientSecret)
        ->setRedirectUri($redirectUri);

    if (!empty($code)) {
        // Get authorization token for access application
        $Token = $Client->authorize($code);
        if ($Token instanceof Token) {
            printf("%s\n", (string) $Token);
        } else {
            var_dump($Token);
        }
    } else {
        // Get authorization uri
        $uri = $Client->createAuthUrl($scopes, true);
        printf("%s\n", $uri);
    }
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}
