<?php
/**
 * Webhook connector class for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Connector;

/**
 * Webhook connector class for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UTWebhookSecond extends ConnectorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->runner->sendMessage(
            "",
            __METHOD__
        );
    }

    /**
     * {@inheritdoc}
     */
    public function release(): void
    {
        $this->runner->sendMessage(
            "",
            __METHOD__
        );
    }
}
