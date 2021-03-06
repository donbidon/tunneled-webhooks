<?php
/**
 * Webhook connector interface.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Connector;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\RunnerInterface;

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
interface ConnectorInterface
{
    /**
     * Constructor.
     *
     * @param RunnerInterface   $runner
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(RunnerInterface $runner, I_Registry $registry);

    /**
     * Registers webhooks.
     *
     * @return void
     */
    public function register(): void;

    /**
     * Releases webhooks.
     *
     * @return void
     */
    public function release(): void;
}
