<?php
/**
 * Webhook handling interface.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler;

/**
 * Webhook handling interface.
 *
 * <!-- move: /namespaces/donbidon.TunneledWebhooks.Webhook.Handler.html -->
 * <p><b>Webhook handling</b></p>
 * <!-- /move -->
 * <!-- copy: /namespaces/donbidon.TunneledWebhooks.Webhook.Handler.html -->
 * See <a href=
 * "../classes/donbidon.TunneledWebhooks.Webhook.Handler.Windbag.html">
 * Windbag class</a> source code.
 * <!-- /copy -->
 *
 * @see Windbag
 */
interface HandlerInterface
{
    /**
     * Constructor.
     *
     * @param IO\IOInterface $io
     */
    public function __construct(IO\IOInterface $io);

    /**
     * Processes request to webhook and sends response.
     *
     * @param mixed $options  Options supporting by implementation
     *
     * @return void
     */
    public function run($options = null);
}
