<?php
/**
 * Bot implementation for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler;

use donbidon\Core\Registry\UT_Recursive;

/**
 * Bot implementation for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UTHandler extends HandlerAbstract
{
    use \donbidon\Core\Log\T_Logger;

    /**
     * {@inheritdoc}
     *
     * @param IO\IOInterface $io
     *
     * @throws \ReflectionException  Risen from UT_Recursive::_get().
     * @throws \donbidon\Core\ExceptionExtended  Risen from T_Logger::log().
     */
    public function __construct(IO\IOInterface $io)
    {
        parent::__construct($io);
        $this->evtManager = UT_Recursive::_get('core/event/manager');
        $this->log("", __METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $options
     *
     * @throws \donbidon\Core\ExceptionExtended  Risen from T_Logger::log().
     */
    public function run($options = null): void
    {
        $options; // to shut up code sniffer
        $message = $this->io->receive();
        $this->log($message, __METHOD__);
        $this->io->send("UT webhook handler message");
    }
}
