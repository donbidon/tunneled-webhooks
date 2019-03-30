<?php
/**
 * Webhook handling I/O abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

use donbidon\Core\Registry\I_Registry;

/**
 * Webhook handling I/O abstract class.
 *
 * Allows to receive/send messages from/to service calling webhook.<br />
 * See <a href=
 * "donbidon.TunneledWebhooks.Webhook.Handler.IO.Telegram.html">
 * Telegram</a> or <a href=
 * "donbidon.TunneledWebhooks.Webhook.Handler.IO.Console.html">
 * Console</a> classes source code.
 *
 * @see Telegram
 * @see Console
 */
abstract class IOAbstract implements IOInterface
{
    /**
     * Webhook registry part
     *
     * @var I_Registry
     */
    protected $registry;

    /**
     * {@inheritdoc}
     *
     * @param I_Registry $registry  Webhook registry part
     */
    public function __construct(I_Registry $registry)
    {
        $this->registry = $registry;
    }
}
