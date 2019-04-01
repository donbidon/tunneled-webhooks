<?php
/**
 * Tunneling service abstract class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Service;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\RunnerInterface;

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
 * @see Ngrok
 */
abstract class ServiceAbstract implements ServiceInterface
{
    /**
     * Runner object
     *
     * @var RunnerInterface
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
     * @param RunnerInterface   $runner
     * @param I_Registry $registry  Service registry part
     */
    public function __construct(RunnerInterface $runner, I_Registry $registry)
    {
        $this->runner   = $runner;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function start(): void
    {
        $this->runner->sendMessage(
            "Starting of tunneling service...",
            __METHOD__
        );
        $pipes = [];
        $this->process = \proc_open(
            $this->registry->get('command'),
            [],
            $pipes,
            null,
            null,
            [
                'bypass_shell' => true,
            ]
        );
        \sleep((int)$this->registry->get('delay', 0));
        $status = \proc_get_status($this->process);
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
    public function stop(?string $reason = null): void
    {
        if (\is_resource($this->process)) {
            \proc_terminate($this->process);
            \proc_close($this->process);
            $message = "Tunneling service stopped";
            if (!\is_null($reason)) {
                $message = \sprintf("%s: %s", $message, $reason);
            }
            $this->runner->sendMessage($message, __METHOD__);
        }
    }
}
