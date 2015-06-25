OdnoklassnikiClient
===================

[🇷🇺](/README.md)
[![Build Status](https://travis-ci.org/alxmsl/OdnoklassnikiClient.png?branch=master)](http://travis-ci.org/alxmsl/OdnoklassnikiClient)

Simple Odnoklassniki API client for:

* OAuth2 [authorization](#oauth2)
* [OK REST API](http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API) methods [calls](#api)

Installation
-------

Require packet in your `composer.json`

```
    "alxmsl/odnoklassnikiclient": "1.0.0"
```

...and update composer: `composer update`

Tests
---

For completely tests running just call `phpunit` command

```
    $ phpunit
    PHPUnit 4.7.5 by Sebastian Bergmann and contributors.
    
    Runtime:	PHP 5.5.23
    
    ....................
    
    Time: 149 ms, Memory: 6.00Mb
    
    OK (20 tests, 100 assertions)
```

## <a name="oauth2"></a> OAuth2 authorization

To authorize client via [Odnoklassniki OAuth2](http://apiok.ru/wiki/display/api/Authorization+OAuth+2.0) you need to 
 create [OAuth2\Client](/source/OAuth2/Client.php) instance with needed client identifier, client secret and redirect 
 uri from you console. Then call `createAuthUrl` with application scopes

```
    $Client = new Client();
    $Client->setClientId(<client identifier>)
        ->setRedirectUri(<redirect URI>);
    
    $url = $Client->createAuthUrl(
        <scopes>
        , <use mobile layout or not>);
```

Compete authorization in browser and give authorization code. With this code you could get an access token

```
    $Client = new Client();
    $Client->setClientId(<client identifier>)
        ->setClientSecret(<client secret key>)
        ->setRedirectUri(<redirect URI>);
    $Token = $Client->authorize(<authorization code>);
```

You could see example [oauth2.uri.php](/examples/oauth2.uri.php) about uri creation, and
 [oauth2.authorize.php](/examples/oauth2.authorize.php) about code authentication. Also you could use completed 
 script [authorize.php](/bin/authorize.php)

```
$ php bin/authorize.php -h
Using: /usr/local/bin/php bin/authorize.php [-h|--help] [-o|--code] -c|--client [-r|--redirect] [-s|--scopes] -e|--secret
-h, --help  - show help
-o, --code  - authorization code
-c, --client  - client id
-r, --redirect  - redirect uri
-s, --scopes  - grant scopes
-e, --secret  - client secret
```

You could refresh access token using [refresh.php](/bin/refresh.php) script

```
$ php bin/refresh.php -h
Using: /usr/local/bin/php bin/refresh.php [-h|--help] -c|--client -r|--redirect -t|--token -s|--secret
-h, --help  - show help
-c, --client  - client id
-r, --redirect  - redirect uri
-t, --token  - refresh token
-s, --secret  - client secret
```

## <a name="api"></a> OK REST API methods calls

For use [OK REST API](http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API) methods you need to create 
 [API\Client](/source/API/Client.php) instance and use method `call` with access token. Already, you could use method
 `callConfidence` with access token auto-refreshing 

```
    $Token = new Token();
    $Token->setAccessToken(<access token>)
        ->setRefreshToken(<refresh token>)
        ->setTokenType(Token::TYPE_SESSION);
    
    $Client = new Client();
    $Client->setApplicationKey(<application key>)
        ->setToken($Token)
        ->setClientId(<client identifier>)
        ->setClientSecret(<client secret>);
    
    $Result = $Client->call(<method name>, <parameters>);
    $Result = $Client->callConfidence(<method name>, <parameters>);
```

You could see examples of `call` and `callConfidence` methods in files 
 [api.users.getCurrentUser.php](/examples/api.users.getCurrentUser.php) and 
 [api.users.getInfo.php](/examples/api.users.getInfo.php)

Of course, you could use script [call.php](/bin/call.php)
 
```
$ php bin/call.php -h
Using: /usr/local/bin/php bin/call.php [-h|--help] -c|--client -d|--data -k|--key -m|--method -s|--secret -t|--token
-h, --help  - show help
-c, --client  - client id
-d, --data  - API method parameters (JSON)
-k, --key  - application key
-m, --method  - API method name
-s, --secret  - client secret
-t, --token  - access token
```

License
-------

Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
