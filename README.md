# Tunneled Webhooks
[![Latest Stable Version](https://img.shields.io/packagist/v/donbidon/tunneled-webhooks.svg?style=flat-square)](https://packagist.org/packages/donbidon/tunneled-webhooks)
[![Packagist](https://img.shields.io/packagist/dt/donbidon/tunneled-webhooks.svg)](https://packagist.org/packages/donbidon/tunneled-webhooks)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/donbidon/tunneled-webhooks.svg)](http://php.net/)
[![GitHub license](https://img.shields.io/github/license/donbidon/tunneled-webhooks.svg)](https://github.com/donbidon/tunneled-webhooks/blob/master/LICENSE)

[![Build Status](https://travis-ci.com/donbidon/tunneled-webhooks.svg?branch=master)](https://travis-ci.com/donbidon/tunneled-webhooks)
[![Code Coverage](https://codecov.io/gh/donbidon/tunneled-webhooks/branch/master/graph/badge.svg)](https://codecov.io/gh/donbidon/tunneled-webhooks)
[![GitHub issues](https://img.shields.io/github/issues-raw/donbidon/tunneled-webhooks.svg)](https://github.com/donbidon/tunneled-webhooks/issues)

[![Donate to liberapay](http://img.shields.io/liberapay/receives/don.bidon.svg?logo=liberapay)](https://liberapay.com/don.bidon/donate)

Runs tunneling service and registers temporary webhooks for workstation having no white IP by one command `/path/to/php bin/run.php /path/to/config.php`.

* IImplemented tunneling services: [ngrok](https://ngrok.com/);
* Implemented webhooks connectors: [Telegram](https://core.telegram.org/bots/api#setwebhook);
* Implemented bots: Windbag.

You can add your own tunneling services, register and handle your own webhooks. 

Look [API documentation](https://donbidon.github.io/docs/apps/tunneled-webhooks/).

## Installing

### Application
Run `composer require donbidon/tunneled-webhooks dev-master`.

### Tunneling services
[Download ngrok](https://ngrok.com/download) (and/or other tunneling services), sign up in service, get auth token and run service once `/path/to/ngrok authtoken %YOUR_AUTH_TOKEN%`.

### Webhooks
[Register Telegram bot](https://core.telegram.org/bots) and receive auth token.

### Configuring local web server (nginx)
Add *.ngrok.io subdomains:
```
server {
    listen   127.0.0.1:80;
    server_name ~^(.*)\.ngrok\.io;

    ; This application www-directory
    root /path/to/www;
}
```
and restart nginx.

### Application config
Copy "data/config.skeleton.php" to "data/config.php" and put ngrok path & Telegram token to the new file:
```ini
...
;;;
; Put path to "ngrok" here:
;;;
command = "/path/to/ngrok http 80"
...
[app.webhook.Telegram.Windbag]
...
token = "%TOKEN%"
...
```

## Usage
Run `/path/to/php bin/run.php data/config.php` from application root directory.

Tunneling service will be started, Telegram webhook will be registered and you could to start conversating with Telegram bot.

## Donation
[Yandex.Money, Visa, MasterCard, Maestro](https://money.yandex.ru/to/41001351141494) or visit [Liberapay](https://liberapay.com/don.bidon/donate).
