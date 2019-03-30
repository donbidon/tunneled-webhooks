<?php
/**
 * Webhook connector abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Connector;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\RunnerInterface;

/**
 * Webhook connector abstract class.
 *
 * See <a href="donbidon.TunneledWebhooks.Webhook.Connector.Telegram.html">
 * Telegram class</a> source code.
 *
 * @see Telegram
 */
abstract class ConnectorAbstract implements ConnectorInterface
{
    /**
     * Runner object
     *
     * @var RunnerInterface
     */
    protected $runner;

    /**
     * Webhook registry part
     *
     * @var I_Registry
     */
    protected $registry;

    /**
     * {@inheritdoc}
     *
     * @param RunnerInterface   $runner
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(RunnerInterface $runner, I_Registry $registry)
    {
        $this->runner   = $runner;
        $this->registry = $registry;
    }
}
