<?php
/**
 * Webhook connector class for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Connector;

/**
 * Webhook connector class for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UT_Webhook_First extends A_Connector
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->runner->sendMessage(
            "",
            __METHOD__
        );
    }

    /**
     * {@inheritdoc}
     */
    public function release()
    {
        $this->runner->sendMessage(
            "",
            __METHOD__
        );
    }
}
