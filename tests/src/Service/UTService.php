<?php
/**
 * Tunneling service class for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

/** @noinspection PhpMissingParentCallCommonInspection */

namespace donbidon\TunneledWebhooks\Service;

/**
 * Tunneling service class for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UTService extends ServiceAbstract
{
    /**
     * {@inheritdoc}
     */
    public function start(): void
    {
        $this->runner->sendMessage("", __METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $reason
     */
    public function stop(string $reason = null): void
    {
        if (is_null($reason)) {
            $reason = "";
        }
        $this->runner->sendMessage($reason, __METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getURL(): string
    {
        $this->runner->sendMessage("", __METHOD__);

        return "ServiceURL";
    }
}
