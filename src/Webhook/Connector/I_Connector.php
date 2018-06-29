<?php
/**
 * Webhook connector interface.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Connector;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\I_Runner;

/**
 * Webhook connector interface.
 *
 * <!-- move: namespaces/donbidon.TunneledWebhooks.Webhook.Connector.html -->
 * <p><b>Webhook connector</b></p>
 * See <a href=
 * "../classes/donbidon.TunneledWebhooks.Webhook.Connector.Telegram.html">
 * Telegram class</a> source code.
 * <!-- /move -->
 * See <a href=
 * "../classes/donbidon.TunneledWebhooks.Webhook.Connector.Telegram.html">
 * Telegram class</a> source code.
 *
 * @see Telegram
 */
interface I_Connector
{
    /**
     * Constructor.
     *
     * @param I_Runner   $runner
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(I_Runner $runner, I_Registry $registry);

    /**
     * Registers webhooks.
     *
     * @return void
     */
    public function register();

    /**
     * Releases webhooks.
     *
     * @return void
     */
    public function release();
}
