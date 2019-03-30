<?php
/**
 * Webhook handling abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler;

/**
 * Webhook handling abstract class.
 *
 * See <a href="donbidon.TunneledWebhooks.Webhook.Handler.Windbag.html">
 * Windbag class</a> source code.
 *
 * @see Windbag
 */
abstract class HandlerAbstract implements HandlerInterface
{
    /**
     * I/O object
     *
     * @var IO\IOInterface
     */
    protected $io;

    /**
     * {@inheritdoc}
     *
     * @param IO\IOInterface $io
     */
    public function __construct(IO\IOInterface $io)
    {
        $this->io = $io;
    }
}
