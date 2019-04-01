<?php
/**
 * Console webhook handling I/O class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

/**
 * Console "webhook" handling I/O class.
 *
 * Allows to receive from \STDIN / send to output messages.<br />
 * Instance created in <a href="../files/bin.bot.windbag.html">Console windbag bot
 * </a>.<br />
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 *
 * @link ../files/bin.bot.windbag.html  Console windbag bot
 */
class Console extends IOAbstract
{
    /**
     * {@inheritdoc}
     *
     * @param mixed $options  Options (not used)
     *
     * @return string
     */
    public function receive($options = null): string
    {
        $options; // to shut up code sniffer
        echo $this->registry->get('prompt', "> ");
        $result = \trim(\fgets(\STDIN));
        // \sleep(1);

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $response
     * @param mixed  $options   Options (not used_
     */
    public function send(string $response, $options = null): void
    {
        $options; // to shut up code sniffer
        echo $response, \PHP_EOL;
    }
}
