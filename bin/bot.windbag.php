<?php
/**
 * Console windbag bot.
 *
 * <ol>
 *     <li>Create your own config file from "<a href=
 * "data.config.skeleton.html">data/config.skeleton.php</a>";</li>
 *     <li>Execute <code>php bin/bot.windbag.php</code>.</li>
 * </ol>
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a> ("bin/bot.windbag.php").
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 *
 * @link ../classes/donbidon.TunneledWebhooks.Webhook.Handler.Windbag.html
 *       \donbidon\TunneledWebhooks\Webhook\Handler\Windbag
 * @link ../classes/donbidon.TunneledWebhooks.Webhook.Handler.IO.Console.html
 *       \donbidon\TunneledWebhooks\Webhook\Handler\IO\Console
 * @link data.config.skeleton.html  data/config.skeleton.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler;

error_reporting(E_ALL);
require_once "../vendor/autoload.php";

$registry =
    \donbidon\Core\Bootstrap::initByPath("../data/config.php")
    ->newFromKey('app/CLI/Console/Windbag');

$bot = new Windbag(new IO\Console($registry));

/**
 * Path to "dictionary" file
 */
$path = sprintf("./%s.txt", basename(__FILE__, ".php"));

while (true) {
    $bot->run($path);
}
