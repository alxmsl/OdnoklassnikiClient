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
 * Odnoklassniki authorization example
 * @author alxmsl
 * @date 8/12/13
 */

include '../vendor/autoload.php';

use alxmsl\Odnoklassniki\OAuth2\Client;
use alxmsl\Odnoklassniki\OAuth2\Response\Token;

// Create and initialize OAuth client
$Client = new Client();
$Client->setClientId(1234567890)
    ->setClientSecret('C11eNt_SEcREt')
    ->setRedirectUri('http://redirect.uri');

// Get authorization token instance by authoprization code
$Token = $Client->authorize('aUTH0R1zAt10N_c0dE');
print_r($Token);

// If success, refresh authorization token
if ($Token instanceof Token) {
    $Token = $Client->refresh('ReFRE5H_t0Ken');
    print_r($Token);
}
