<?php
/**
 * Tunneling service interface.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks\Service;

use donbidon\Core\Registry\I_Registry;
use donbidon\TunneledWebhooks\RunnerInterface;

/**
 * Tunneling service interface.
 *
 * <!-- move: namespaces/donbidon.TunneledWebhooks.Service.html -->
 * <p><b>Tunneling service</b></p>
 * <ul>
 * <li><a href="../classes/donbidon.TunneledWebhooks.Service.I_Service.html">
 * Implementing interface</a>;</li>
 * <li><a href="../classes/donbidon.TunneledWebhooks.Service.A_Service.html">
 * Extending abstract class</a>.</li>
 * </ul>
 * <!-- /move -->
 * ```php
 * namespace MyNamespace;
 *
 * class ServiceImplementingInterface implements
 *     \donbidon\TunneledWebhooks\Service\I_Service
 * {
 *     public function __construct(
 *         \donbidon\TunneledWebhooks\I_Runner $runner,
 *         \donbidon\Core\Registry\I_Registry $registry
 *     )
 *     {
 *         // Constructor code
 *     }
 *
 *     public function start()
 *     {
 *         // Code starting service
 *     }
 *
 *     public function stop($reason = null)
 *     {
 *         // Code stopping service
 *     }
 *
 *     public function getURL()
 *     {
 *         // Code returning tunneling url
 *     }
 * }
 * ```
 * config section:
 * ```ini
 * [app.service]
 * class = "\\MyNamespace\\ServiceImplementingInterface"
 * ; Settings whatever your service needed...
 * ```
 *
 * @see Ngrok
 */
interface ServiceInterface
{
    /**
     * Constructor.
     *
     * @param RunnerInterface   $runner
     * @param I_Registry $registry  Service registry part
     */
    public function __construct(RunnerInterface $runner, I_Registry $registry);

    /**
     * Starts service.
     *
     * @return void
     */
    public function start();

    /**
     * Stops service.
     *
     * @param string $reason
     *
     * @return void
     */
    public function stop($reason = null);

    /**
     * Returns service URL.
     *
     * @return string
     */
    public function getURL();
}
