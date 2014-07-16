OdnoklassnikiClient
===================

Simple client for Odnoklassniki API

Installation
-------

Require packet in a composer.json

    "alxmsl/odnoklassnikiclient": ">=1.0.0"

Run Composer: `php composer.phar install`

OAuth example
-------

Firstly you will need to initialize OAuth client

    use alxmsl\Odnoklassniki\OAuth\Client;

    $Client = new Client();
    $Client->setClientId(1234567890)
        ->setClientSecret('C11eNt_SEcREt')
        ->setRedirectUri('http://redirect.uri');

then get authorization url with needed scopes

    $url = $Client->createAuthUrl(array(
        Client::SCOPE_VALUABLE_ACCESS,
        Client::SCOPE_SET_STATUS,
        Client::SCOPE_PHOTO_CONTENT,
    ), true);

Use browser to get authorization code and token

    $Token = $Client->authorize('aUTH0R1zAt10N_c0dE');

Time-to-time update your token

    $Token = $Client->refresh('ReFRE5H_t0Ken');

API usage example
-------

Just initialize API client instance

    $Client = new Client();
    $Client->setApplicationKey('4Pp1IC4t10n_KEy')
        ->setToken($Token)
        ->setClientId(1234567890)
        ->setClientSecret('C11eNt_SEcREt');

You will need to use OAuth token from previous example. Or create it from some storage

    $Token = new Token();
    $Token->setAccessToken('4cCE5s_T0KEn')
        ->setRefreshToken('ReFRE5H_t0Ken')
        ->setTokenType(Token::TYPE_SESSION);

And now you can call [Odnoklassniki API](http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API) methods

    $Result = $Client->callConfidence('users.getCurrentUser');

License
-------
Copyright © 2014 Alexey Maslov <alexey.y.maslov@gmail.com>
This work is free. You can redistribute it and/or modify it under the
terms of the Do What The Fuck You Want To Public License, Version 2,
as published by Sam Hocevar. See the COPYING file for more details.
