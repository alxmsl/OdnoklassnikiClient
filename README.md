OdnoklassnikiClient
===================

[🇬🇧](/README.en.md)
[![Build Status](https://travis-ci.org/alxmsl/OdnoklassnikiClient.png?branch=master)](http://travis-ci.org/alxmsl/OdnoklassnikiClient)

Клиент для работы с API социальной сети "Одноклассники". Клиент позволяет выполнять следующее:

* [Авторизацию](#oauth2) OAuth2
* [Вызовы](#api) методов [OK REST API](http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API+ru)

Установка
-------

Просто подключите библиотеку нужной версии в файле `composer.json`

```
    "alxmsl/odnoklassnikiclient": "1.0.0"
```

Затем запустите обновление кода `composer update`

Тестирование
---

Для проверки работоспособности библиотеки, можно запустить юнит-тестирование командой `phpunit`

```
    $ phpunit
    PHPUnit 4.7.5 by Sebastian Bergmann and contributors.
    
    Runtime:	PHP 5.5.23
    
    ....................
    
    Time: 149 ms, Memory: 6.00Mb
    
    OK (20 tests, 100 assertions)
```

## <a name="oauth2"></a> Авторизация OAuth2

Для авторизации через [OAuth2 в "Одноклассниках"](http://apiok.ru/wiki/pages/viewpage.action?pageId=42476652) необходимо
 создать экземпляр класса [OAuth\Client](/source/OAuth2/Client.php) и, с необходимами правами для приложения, получить 
 код авторизации, выполнив авторизацию через браузер, пройдя по созданной методом `createAuthUrl` ссылке 

```
    $Client = new Client();
    $Client->setClientId(<идентификатор прилоежния>)
        ->setRedirectUri(<URI переадресации для кода>);
    
    $url = $Client->createAuthUrl(
        <массив интересующих прав>
        , <флаг необходимости мобильного лейаута для авторизации в браузере>);
```

По коду можно выполнить авторизацию и получить токен доступа и токен обновления (токена доступа)

```
    $Client = new Client();
    $Client->setClientId(<идентификатор прилоежния>)
        ->setClientSecret(<секретный ключ приложения>)
        ->setRedirectUri(<URI переадресации для кода>);
    $Token = $Client->authorize(<код авторизации>);
```

Пример получения ссылки для авторизации можно посмотреть в файле [oauth2.uri.php](/examples/oauth2.uri.php), а получение 
 токена доступа в файле [oauth2.authorize.php](/examples/oauth2.authorize.php)

Авторизацию также можно выполнить через скрипт [authorize.php](/bin/authorize.php)

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

Обновить токен доступа можно через скрипт [refresh.php](/bin/refresh.php)

```
$ php bin/refresh.php -h
Using: /usr/local/bin/php bin/refresh.php [-h|--help] -c|--client -r|--redirect -t|--token -s|--secret
-h, --help  - show help
-c, --client  - client id
-r, --redirect  - redirect uri
-t, --token  - refresh token
-s, --secret  - client secret
```

## <a name="api"></a> Вызовы методов OK REST API

Для обращения к методам [OK REST API](http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API+ru) необходимо создать 
 экземпляр клиента [API\Client](/source/API/Client.php) и, определив токен доступа, начать дергать метод `call`. А можно 
 дергать `callConfidence`, если за время подергивания планируется истечение авторизованной сессии токена доступа 

```
    $Token = new Token();
    $Token->setAccessToken(<токен доступа>)
        ->setRefreshToken(<токен обновления>)
        ->setTokenType(Token::TYPE_SESSION);
    
    $Client = new Client();
    $Client->setApplicationKey(<ключ приложения>)
        ->setToken($Token)
        ->setClientId(<идентификатор приложения>)
        ->setClientSecret(<секретный ключ приложения>);
    
    $Result = $Client->call(<метод>, <массив параметров вызова>);
    $Result = $Client->callConfidence(<метод>, <массив параметров вызова>);
```

Примеры использования `call` и `callConfidence` можно подсмотреть в файлах 
 [api.users.getCurrentUser.php](/examples/api.users.getCurrentUser.php) и 
 [api.users.getInfo.php](/examples/api.users.getInfo.php)
 
Аналогично, можно использовать скрипт выполнения метода OK REST API [call.php](/bin/call.php)

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

Лицензия
-------

Авторское право © 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
Лицензировано Apache License, Version 2.0. С полным текстом лицензии 
можно ознакомиться по ссылке

    http://www.apache.org/licenses/LICENSE-2.0
