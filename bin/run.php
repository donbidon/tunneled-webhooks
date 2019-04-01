<?php
/**
 * Starts tunneling service and register webhooks.
 *
 * <ol>
 *     <li>Create your own config file from "<a href=
 * "data.config.skeleton.html">data/config.skeleton.php</a>";</li>
 *     <li>Execute <code>php bin/run.php /path/to/config.php</code>.</li>
 * </ol>
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code
 * </i></a> ("bin/run.php").
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 *
 * @link ../classes/donbidon.TunneledWebhooks.Runner.html
 *       \donbidon\TunneledWebhooks\Runner
 * @link data.config.skeleton.html  data/config.skeleton.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks;

\error_reporting(\E_ALL);
/** @noinspection PhpIncludeInspection */
require_once \sprintf("%s/../vendor/autoload.php", __DIR__);

$output = [
    "Tunneled Webhooks",
    "",
];
if (2 != $argc) {
    $php = \getenv('PHPBIN') ? \getenv('PHPBIN') : "php";
    $output[] = "Starts tunneling service and register appropriate webhooks.";
    $output[] = \sprintf(
        "Usage: %s %s path/to/config",
        $php,
        $_SERVER['PHP_SELF']
    );
    $output[] = "";
}

echo \implode(\PHP_EOL, $output);
if (2 != $argc) {
    die;
}

/**
 * Path to config file
 */
$path = $argv[1];

/** @noinspection PhpUnhandledExceptionInspection */
new Runner($path);
