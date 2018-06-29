# Tunneled webhooks

Runs tunneling service and registers temporary webhooks for workstation having no white IP by one command `/path/to/php bin/run.php /path/to/config.php`.

* IImplemented tunneling services: [ngrok](https://ngrok.com/);
* Implemented webhooks connectors: [Telegram](https://core.telegram.org/bots/api#setwebhook);
* Implemented bots: Windbag.

You can add your own tunneling services, register and handle your own webhooks. 

Look [API documentation](https://donbidon.github.io/docs/apps/tunneled-webhooks/).

## Installing

### Application
Run `composer require donbidon/tunneled-webhooks dev-master` or add following code to your "composer.json" file:
```json
    "require": {
        "donbidon/tunneled-webhooks": "dev-master"
    }
```
and run `composer update`.

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
Copy "data/config.skeleton.php" to "data/config.php" and put ngrok path/Telegram token to the new file:
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
