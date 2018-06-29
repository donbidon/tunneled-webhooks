<?php
/**
 * Webhook handling abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler;

/**
 * Webhook handling abstract class.
 *
 * See <a href="donbidon.TunneledWebhooks.Webhook.Handler.Windbag.html">
 * Windbag class</a> source code.
 *
 * @see Windbag
 */
abstract class A_Handler implements I_Handler
{
    /**
     * I/O object
     *
     * @var IO\I_IO
     */
    protected $io;

    /**
     * {@inheritdoc}
     *
     * @param IO\I_IO $io
     */
    public function __construct(IO\I_IO $io)
    {
        $this->io = $io;
    }
}
