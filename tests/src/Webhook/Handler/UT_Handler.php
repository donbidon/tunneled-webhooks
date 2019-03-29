<?php
/**
 * Bot implementation for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler;

use donbidon\Core\ExceptionExtended as ExceptionExtended;
use donbidon\Core\Registry\UT_Recursive;

/**
 * Bot implementation for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UT_Handler extends A_Handler
{
    use \donbidon\Core\Log\T_Logger;

    /**
     * {@inheritdoc}
     *
     * @param IO\I_IO $io
     *
     * @throws \ReflectionException  Risen from UT_Recursive::_get().
     * @throws ExceptionExtended  Risen from T_Logger::log().
     */
    public function __construct(IO\I_IO $io)
    {
        parent::__construct($io);
        $this->evtManager = UT_Recursive::_get('core/event/manager');
        $this->log("", __METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $options
     *
     * @throws ExceptionExtended  Risen from T_Logger::log().
     */
    public function run($options = null)
    {
        $message = $this->io->receive();
        $this->log($message, __METHOD__);
        $this->io->send("UT webhook handler message");
    }
}
