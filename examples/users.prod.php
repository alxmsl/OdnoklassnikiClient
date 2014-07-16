<?php
/**
 * 
 * @author alxmsl
 * @date 8/13/13
 */

include('../source/Autoloader.php');
include '../vendor/alxmsl/network/source/Autoloader.php';

use alxmsl\Odnoklassniki\OAuth\Response\Token;
use alxmsl\Odnoklassniki\API\Client;

$Token = new Token();
$Token->setAccessToken('b3ipa.4061dvrsxx00v1t4620n583k1d')
//    ->setRefreshToken('c55064418f68d9eed4666a7d64acfa48946_560709229025_138478772')
    ->setTokenType(Token::TYPE_SESSION);

$Client = new Client();
$Client->setApplicationKey('CBACFNHMABABABABA')
    ->setToken($Token)
    ->setClientId(192696576)
    ->setClientSecret('A9872F0F0DA2EA47EB876D85');

//$R = $Client->call('users.isAppUser');
//var_dump($R);

//$R = $Client->callConfidence('users.isAppUser');
//var_dump($R);

$R = $Client->callConfidence('users.getCurrentUser');
var_dump($R);

//$R = $Client->callConfidence('users.getInfo', array(
//    'uids' => 560709229025,
//    'fields' => 'first_name,age,gender,location,pic_2,pic_3,pic_4',
//));
//var_dump(current($R));

//$Result = $Client->callConfidence('photos.getPhotos');
//var_dump($Result);
