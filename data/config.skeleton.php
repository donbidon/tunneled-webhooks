<?php
/**
 * Config file skeleton.
 *
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code
 * </i></a> ("data/config.skeleton.php").
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 *
 * @link bin.run.html  bin/run.php
 * @link bin.bot.windbag.html  bin/bot.windbag.php
 * @link www.com.telegram.bot.windbag.html  www/telegram/bot.windbag.php
 */

die; __halt_compiler();
?>

[core.log.Stream.E_ALL]
stream = "php://output"
source[] = "*"

; [core.log.File.E_ALL]
; source[] = "*"
; path     = "/path/to/log"
; rotation = 1
; rights   = 0666


[app.service]
; Set full class name (including namespace) to use own service.
class  = "Ngrok"
;;;
; Put path to "ngrok" here:
;;;
command = "/path/to/ngrok http 80"
;;;
; Delay after starting service.
; 3 seconds enough to start service and connect their servers at my place.
;;;
delay   = 3 ; In seconds
status  = "http://localhost:4040/status" ; Default ngrok status page


[app.webhook.Telegram.Windbag]
; Full class name (including namespace) to use own webhook, not set by default
; class        = "\\own\\namespace\\Webhook\Connector"
;;;
; See project documentation.
;;;
url.register = "https://api.telegram.org/bot%s/setWebhook?url=%s/telegram/windbag.php"
url.release  = "https://api.telegram.org/bot%s/deleteWebhook"
;;;
; Put your Telegram token here (see https://core.telegram.org/bots):
;;;
token        = "%TOKEN%"

; [app.webhook.Telegram.myBot]
; class = "\\MyNamespace\\MyBot"
; ....


[app.CLI.Console.Windbag]
prompt = "windbag> "
