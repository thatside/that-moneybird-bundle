ThatMoneybirdBundle
==================

[![Build Status](https://travis-ci.org/thatside/that-moneybird-bundle.svg?branch=master)](https://travis-ci.org/thatside/that-moneybird-bundle)

MoneyBird Bundle for Symfony 2 Applications. Bundle provides wrapper for [moneybird-php-client](https://github.com/picqer/moneybird-php-client)

Based on [KamiLabs work](https://github.com/kamilabs/MoneyBirdApiBundle)

TBD!!!

Installation
-------------

### 1. Download:
Prefered way to install this bundle is using [composer](http://getcomposer.org)

Download the bundle with composer:
```bash
$ php composer.phar require "thatside/that-moneybird-bundle"
```
### 2. Enable the bundle in the kernel:

```
<?php

// app/AppKernel.php


public function registerBundles()
{
    $bundles = array(
        // ...

        new Thatside\MoneybirdBundle\ThatMoneybirdBundle(),
    );
}
```
### 3. Configure the bundle:

Add the following configuration to your config.yml.
```
# app/config/config.yml
that_moneybird:
    redirect_url: localhost
    client_id: test_client_id
    client_secret: test_client_secret
    debug: false # optional parameter for test mode activation
```

Only first three configuration values are required to use the bundle.
Redirect URL is required to be non-localhost so use any tunneling service to test.
(https://github.com/beameio/beame-insta-ssl recommended).


Tokens storage
--------------

You need to set things up first to store auth code and access token somewhere.
1. Redefine `that_moneybird.code_fetcher` service with your own class (use `CodeFetcherInterface` for this).
2. Add an event subscriber listening to `moneybird.token_update` event (see `MoneybirdTokenEvent`).
3. Manually save authorization code after Moneybird authorization

MoneyBird Service
--------------

Core component of this bundle is MoneyBird service.
It provides simple wrapper around Picqer Moneybird class - it is available by `getMoneybird()` call.

Still thinking on using `__call` here...
```
<?php
    $this->get('that_moneybird'); 
```



