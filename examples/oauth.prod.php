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

$Client = new Client();
$Client->setClientId(192696576)
    ->setClientSecret('A9872F0F0DA2EA47EB876D85')
    ->setRedirectUri('http://ok.ru/games/topfacecom');

$url = $Client->createAuthUrl(array(
    Client::SCOPE_VALUABLE_ACCESS,
    Client::SCOPE_SET_STATUS,
    Client::SCOPE_PHOTO_CONTENT,
), true);
var_dump($url);

//$r = $Client->authorize('997f7478cabbfeb72aad44fd0ffc69e4dc7c1434f2b4788fb295728cb.8_bfaefcf804b7eab58ea512b4572d2c2f_1376395172');
//var_dump($r);

/*
object(Odnoklassniki\Client\OAuth\Response\Token)#5 (3) {
["accessToken":"Odnoklassniki\Client\OAuth\Response\Token":private]=>
string(33) "evipa.828k7qao052x3o4w2q133k19sr9"
["refreshToken":"Odnoklassniki\Client\OAuth\Response\Token":private]=>
string(58) "482c3f6cf867ccd96b322cb18bd1a7110b_552410809159_1376395181"
["tokenType":"Odnoklassniki\Client\OAuth\Response\Token":private]=>
string(7) "session"
}
*/

//$r = $Client->refresh('482c3f6cf867ccd96b322cb18bd1a7110b_552410809159_1376395181');
//var_dump($r);
