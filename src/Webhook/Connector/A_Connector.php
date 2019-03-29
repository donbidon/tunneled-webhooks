<?php
/**
 * Webhook connector abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Connector;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\I_Runner;

/**
 * Webhook connector abstract class.
 *
 * See <a href="donbidon.TunneledWebhooks.Webhook.Connector.Telegram.html">
 * Telegram class</a> source code.
 *
 * @see Telegram
 */
abstract class A_Connector implements I_Connector
{
    /**
     * Runner object
     *
     * @var I_Runner
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
     * @param I_Runner   $runner
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(I_Runner $runner, I_Registry $registry)
    {
        $this->runner   = $runner;
        $this->registry = $registry;
    }
}
