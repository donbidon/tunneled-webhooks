<?php
/**
 * Runner interface.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks;

/**
 * Runner interface.
 *
 * @link ../files/bin.run.html bin/run.php
 */
interface RunnerInterface
{
    /**
     * Constructor.
     *
     * @param string $path  Path to config
     */
    public function __construct(string $path);

    /**
     * Returns tunneling service URL.
     *
     * @return string
     */
    public function getServiceURL(): string;

    /**
     * Sends message.
     *
     * @param string $message
     * @param string $source
     *
     * @return void
     */
    public function sendMessage(string $message, string $source): void;

    /**
     * Stops service, sends error and exits.
     *
     * @param string $message
     * @param string $source
     *
     * @return void
     */
    public function sendError(string $message, string $source): void;
}
