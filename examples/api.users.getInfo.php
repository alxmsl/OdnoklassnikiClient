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
 * Odnoklassniki API method users.getInfo example
 * @author alxmsl
 * @date 8/13/13
 */

include '../vendor/autoload.php';

use alxmsl\Odnoklassniki\OAuth2\Response\Token;
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

// Get current user big size avatar
$Result = $Client->callConfidence('users.getInfo', array(
    'uids'   => 1,
    'fields' => 'pic_4',
));
print_r($Result);
