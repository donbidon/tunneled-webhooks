<?php
/**
 * Webhook handling I/O interface.
 *
 * Allows to receive/send messages from/to service calling webhook.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

use donbidon\Core\Registry\I_Registry;

/**
 * Webhook handling I/O interface.
 *
 * <!-- move: /namespaces/donbidon.TunneledWebhooks.Webhook.Handler.IO.html -->
 * <p><b>Webhook handling I/O</b></p>
 * <!-- /move -->
 * <!-- copy: /namespaces/donbidon.TunneledWebhooks.Webhook.Handler.IO.html -->
 * Allows to receive/send messages from/to service calling webhook.<br />
 * See <a href=
 * "../classes/donbidon.TunneledWebhooks.Webhook.Handler.IO.Telegram.html">
 * Telegram</a> or <a href=
 * "../classes/donbidon.TunneledWebhooks.Webhook.Handler.IO.Console.html">
 * Console</a> classes source code.
 * <!-- /copy -->
 *
 * @see Telegram
 * @see Console
 */
interface IOInterface
{
    /**
     * Constructor.
     *
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(I_Registry $registry);

    /**
     * Returns request from service called webhook.
     *
     * @param mixed $options  Options supporting by implementation
     *
     * @return mixed
     */
    public function receive($options = null);

    /**
     * Sends response to service called webhook.
     *
     * @param string $response
     * @param mixed  $options   Options supporting by implementation
     *
     * @return void
     */
    public function send($response, $options = null);
}
