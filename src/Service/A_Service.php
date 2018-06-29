<?php
/**
 * Tunneling service abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Service;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\I_Runner;

/**
 * Tunneling service abstract class.
 *
 * ```php
 * namespace MyNamespace;
 *
 * class ServiceExtendingAbstractClass extends
 *     \donbidon\TunneledWebhooks\Service\A_Service
 * {
 *     public function getURL()
 *     {
 *         // Code returning tunneling url
 *     }
 * }
 * ```
 * config section:
 * ```ini
 * [app.service]
 * class   = "\\MyNamespace\\ServiceExtendingAbstractClass"
 * command = "/path/to/service/executable arguments"
 * ;;;
 * ; Delay after starting service.
 * ; 3 seconds enough to start service and connect their servers at my place.
 * ;;;
 * delay   = 3 ; In seconds
 * ; Settings whatever your service needed...
 * ```
 *
 * @see ngrok
 */
abstract class A_Service implements I_Service
{
    /**
     * Runner object
     *
     * @var I_Runner
     */
    protected $runner;

    /**
     * Service registry part
     *
     * @var I_Registry
     */
    protected $registry;

    /**
     * Resource of process
     *
     * @var resource
     */
    protected $process;

    /**
     * {@inheritdoc}
     *
     * @param I_Runner   $runner
     * @param I_Registry $registry  Service registry part
     */
    public function __construct(I_Runner $runner, I_Registry $registry)
    {
        $this->runner   = $runner;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->runner->sendMessage(
            "Starting of tunneling service...",
            __METHOD__
        );
        $pipes = [];
        $this->process = proc_open(
           $this->registry->get('command'),
            [],
            $pipes,
            null,
            null,
            [
                'bypass_shell' => TRUE,
            ]
        );
        sleep($this->registry->get('delay', 0));
        $status = proc_get_status($this->process);
        if (empty($status['running'])) {
            $this->runner->sendError(
                "Starting of tunneling service failed",
                __METHOD__
            );
        } else {
            $this->runner->sendMessage(
                "Tunneling service started successfully",
                __METHOD__
            );
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param string $reason
     */
    public function stop($reason = null)
    {
        if (is_resource($this->process)) {
            proc_terminate($this->process);
            proc_close($this->process);
            $message = "Tunneling service stopped";
            if (!is_null($reason)) {
                $message = sprintf("%s: %s", $message, $reason);
            }
            $this->runner->sendMessage($message, __METHOD__);
        }
    }
}
