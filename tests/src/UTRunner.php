<?php
/**
 * Runner class extension for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

/** @noinspection PhpMissingParentCallCommonInspection */

namespace donbidon\TunneledWebhooks;

/**
 * Runner class extension for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UTRunner extends Runner
{
    /** @noinspection PhpMissingParentConstructorInspection */
    /**
     * {@inheritdoc}
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->registry = \donbidon\Core\UT_Bootstrap::initByPath($path);
        $this->evtManager = $this->registry->get('core/event/manager');

        $this->run();
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $message
     * @param  string $source
     */
    public function sendError(string $message, string $source): void
    {
        $this->service->stop();
        $this->log($message, $source, \E_ERROR);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \donbidon\Core\ExceptionExtended  Risen from self::sendError().
     */
    protected function infiniteLoop(): void
    {
        $this->sendError("", __METHOD__);
    }
}
