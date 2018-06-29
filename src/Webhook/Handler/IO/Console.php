<?php
/**
 * Console webhook handling I/O class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

/**
 * Console "webhook" handling I/O class.
 *
 * Allows to receive from STDIN / send to output messages.<br />
 * Instance created in <a href="../files/bin.bot.windbag.html">Console windbag bot
 * </a>.<br />
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 *
 * @link ../files/bin.bot.windbag.html  Console windbag bot
 */
class Console extends A_IO
{
    /**
     * {@inheritdoc}
     *
     * @param mixed $options  Options (not used)
     *
     * @return string
     */
    public function receive($options = null)
    {
        echo $this->registry->get('prompt', "> ");
        $result = trim(fgets(STDIN));
        // sleep(1);

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $response
     * @param mixed  $options   Options (not used_
     */
    public function send($response, $options = null)
    {
        echo $response, PHP_EOL;
    }
}
