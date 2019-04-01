<?php
/**
 * Windbag bot implementation.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler;

/**
 * Windbag bot implementation.
 *
 * Instance created in <a href="../files/www.com.telegram.bot.windbag.html">
 * Telegram windbag bot</a> and <a href="../files/bin.bot.windbag.html">Console windbag
 * bot</a>.<br />
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 *
 * @link ../files/www.com.telegram.bot.windbag.html  Telegram windbag bot
 * @link ../files/bin.bot.windbag.html  Console windbag bot
 */
class Windbag extends HandlerAbstract
{
    /**
     * {@inheritdoc}
     *
     * @param string $path  Path to file containing previous incoming phrases
     */
    public function run($path = null): void
    {
        $message = $this->io->receive();
        if (\is_null($message)) {
            return;
        }

        \mt_srand();
        $messages = \file_exists($path) ? \file($path) : [];
        $count = \sizeof($messages);
        if ($count > 0) {
            $index = \mt_rand(0, $count - 1);
            $reply = \trim($messages[$index]);
        } else {
            $reply = ":)";
        }
        $this->io->send($reply);
        $messages[] = $message . \PHP_EOL;
        \file_put_contents($path, \implode("", $messages));
    }
}
