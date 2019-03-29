<?php
/**
 * Webhook handling I/O class for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

use donbidon\Core\ExceptionExtended as ExceptionExtended;
use donbidon\Core\Registry\I_Registry;
use donbidon\Core\Registry\UT_Recursive;


/**
 * Webhook handling I/O class for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UT_IO extends A_IO
{
    use \donbidon\Core\Log\T_Logger;

    /**
     * {@inheritdoc}
     *
     * @param I_Registry $registry
     *
     * @throws \ReflectionException  Risen from UT_Recursive::_get().
     * @throws ExceptionExtended  Risen from T_Logger::log().
     */
    public function __construct(I_Registry $registry)
    {
        parent::__construct($registry);
        $this->evtManager = UT_Recursive::_get('core/event/manager');
        $this->log("", __METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $options  Options (not used)
     *
     * @return string
     */
    public function receive($options = null)
    {
        return "UI external service message";
    }

    /**
     * {@inheritdoc}
     *
     * @param string $response
     * @param mixed  $options   Options (not used_
     *
     * @throws ExceptionExtended  Risen from T_Logger::log().
     */
    public function send($response, $options = null)
    {
        $this->log($response, __METHOD__);
    }
}
