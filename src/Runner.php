<?php
/**
 * Runner.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks;

use donbidon\Core\Bootstrap;
use donbidon\Core\Event\Args;
use donbidon\Core\Log\T_Logger;
use RuntimeException;
use Throwable;

/**
 * Runs tunnelling service and registers webhooks.
 *
 * Instance created in "<a href="../files/bin.run.html">bin/run.php
 * </a>".
 * <!-- move: index.html -->
 * <h1>Tunneled Webhooks</h1>
 * <b>Runs tunneling service and register temporary webhooks for workstation
 * having no white IP by one command
 * `/path/to/php bin/run.php /path/to/config.php`.</b>
 * <ul>
 *     <li>IImplemented tunneling services: <a href=
 * "classes/donbidon.TunneledWebhooks.Service.ngrok.html">ngrok</a> <a href=
 * "https://ngrok.com/" target="_blank" class="external" title="ngrok official
 * site"><i class="fa fa-external-link-alt"></i></a>;</li>
 *     <li>Implemented webhooks connectors: <a href=
 * "classes/donbidon.TunneledWebhooks.Webhook.Connector.Telegram.html">
 * Telegram</a> <a href="https://core.telegram.org/bots/api" target="_blank"
 * class="external" title="Telegram Bot API"><i class="fa fa-external-link-alt">
 * </i></a>;</li>
 *     <li>Implemented bots: <a href=
 * "classes/donbidon.TunneledWebhooks.Webhook.Handler.Windbag.html">Windbag</a>.
 * </li>
 * </ul>
 * You can add your own <a href=
 * "namespaces/donbidon.TunneledWebhooks.Service.html">tunneling services</a>,
 * <a href=
 * "namespaces/donbidon.TunneledWebhooks.Webhook.Connector.html">register</a>
 * and <a href=
 * "namespaces/donbidon.TunneledWebhooks.Webhook.Handler.html">handle</a>
 * your own webhooks.<br />
 * See "<a href="files/bin.run.html">bin/run.php</a>".
 * <hr />
 * "hosts" file:
 * ```
 * # Optional, just for testing
 * 127.0.0.1 localhost.ngrok.io
 * ```
 * nginx "io.ngrok.conf":
 * ```conf
 * server {
 *     listen   127.0.0.1:80;
 *     server_name ~^(.*)\.ngrok\.io;
 *
 *     ; This application www-directory
 *     root /path/to/www;
 *     ...
 * }
 * ```
 * "config.php" file:
 * ```ini
 * ; <?php die; __halt_compiler();
 *
 * [core.log.Stream.\E_ALL]
 * stream = "php://output"
 * source[] = "*"
 *
 * ; [core.log.File.\E_ALL]
 * ; source[] = "*"
 * ; path     = "/path/to/log"
 * ; rotation = 1
 * ; rights   = 0666
 *
 * [app.service]
 * ; Set full class name (including namespace) to use own service.
 * class  = "ngrok"
 * ;;;
 * ; Put path to "ngrok" here:
 * ;;;
 * command = "/path/to/ngrok http 80"
 * ;;;
 * ; Delay after starting service.
 * ; 3 seconds enough to start service and connect their servers at my place.
 * ;;;
 * delay   = 3 ; In seconds
 * status  = "http://localhost:4040/status" ; Default ngrok status page
 *
 * [app.webhook.Telegram.Windbag]
 * ; Full class name (including namespace) to use own webhook, not set by default
 * ; class        = "\\own\\namespace\\Webhook"
 * ;;;
 * ; See project documentation.
 * ;;;
 * url.register = "https://api.telegram.org/bot%s/setWebhook?url=%s/telegram/bot.windbag.php"
 * ;;;
 * ; Put your Telegram token here:
 * ;;;
 * token        = "%TOKEN%"
 *
 * ; [app.webhook.Telegram.myBot]
 * ; class = "\\MyNamespace\\MyBot"
 * ; ....
 *
 * [app.CLI.Console.Windbag]
 * prompt = "windbag> "
 * ```
 * <!-- /move -->
 *
 * @link ../files/bin.run.html bin/run.php
 */
class Runner implements RunnerInterface
{
    use T_Logger;

    /**
     * Registry object
     *
     * @var \donbidon\Core\Registry\I_Registry
     */
    protected $registry;

    /**
     * Tunneling service object
     *
     * @var Service\ServiceInterface
     */
    protected $service;

    /**
     * Array of Webhook\Connector instances.
     *
     * @var Webhook\Connector\ConnectorInterface[]
     *
     * @see self::register()
     * @see self::handleShutdown()
     */
    protected $webhooks = [];

    /**
     * {@inheritdoc}
     *
     * @param string $path  Path to config
     *
     * @throws Throwable
     */
    public function __construct(string $path)
    {
        $this->registry   = Bootstrap::initByPath($path);
        $this->evtManager = $this->registry->get('core/event/manager');
        $path = \implode(\DIRECTORY_SEPARATOR, [
            \dirname($path), "run.log",
        ]);
        $this->evtManager->fire(
            ':updateLogRegistry:',
            new Args([
                'conditions' => [
                    'name'  => "File",
                    'level' => "\E_ALL",
                ],
                'changes' => [
                    'path' => $path,
                ],
            ])
        );

        if (\function_exists('pcntl_signal')) {
            \pcntl_signal(\SIGTERM, [$this, 'handleShutdown']);
        }

        $this->run();
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceURL(): string
    {
        return $this->service->getURL();
    } //end getServiceURL()

    /**
     * {@inheritdoc}
     *
     * @param string $message
     * @param string $source
     *
     * @throws \donbidon\Core\ExceptionExtended  Risen from \donbidon\Core\Log\T_Logger::log().
     */
    public function sendMessage(string $message, string $source): void
    {
        $this->log($message, $source);
    } //end sendMessage()

    /**
     * {@inheritdoc}
     *
     * @param string $message
     * @param string $source
     *
     * @throws \donbidon\Core\ExceptionExtended  Risen from \donbidon\Core\Log\T_Logger::log().
     */
    public function sendError(string $message, string $source): void
    {
        $this->service->stop($message);
        $this->log($message, $source, \E_ERROR);
        exit(1);
    }

    /**
     * Handles terminate signal.
     *
     * @param int   $number
     * @param mixed $info
     *
     * @return void
     */
    public function handleShutdown(/** @noinspection PhpUnusedParameterInspection */ int $number, $info = null): void
    {
        $number; // to shut up code sniffer
        $info; // to shut up code sniffer
        foreach ($this->webhooks as $instance) {
            $instance->release();
        }
        $this->service->stop("Runner stopped");
    } //end handleShutdown()

    /**
     * Main loop.
     *
     * @throws Throwable
     *
     * @return void
     */
    protected function run(): void
    {
        try {
            $this->startService();
            $this->registerWebhooks();
            $this->infiniteLoop();
        } catch (Throwable $e) {
            if (\is_object($this->service)) {
                $this->service->stop(\sprintf(
                    "%s%s%s",
                    $e->getMessage(),
                    $e->getTraceAsString()
                ));
            }
            throw $e;
        }
    }

    /**
     * Starts tunneling service.
     *
     * @return void
     *
     * @throws RuntimeException  If passed service doesn't implement
     *         Service\I_Service.
     *
     * @see self::__construct()
     */
    protected function startService(): void
    {
        $registry = $this->registry->newFromKey('app/service');
        $service = $registry->get('class');
        $class = false === \strpos($service, "\\")
            ? \sprintf(
                "\\donbidon\\TunneledWebhooks\\Service\\%s",
                $service
            ) : $service;
        /**
         * @var Service\ServiceInterface
         */
        $this->service = new $class($this, $registry);
        if (!($this->service instanceof Service\ServiceInterface)) {
            throw new RuntimeException(\sprintf(
                "Class %s has to implement %s",
                $class,
                Service\ServiceInterface::class
            ));
        }
        $this->service->start();
    }

    /**
     * Registers webhooks.
     *
     * @return void
     *
     * @throws RuntimeException  If passed webhook doesn't implement
     *         Webhook\I_IO.
     * @throws \donbidon\Core\ExceptionExtended  Risen from self::sendMessage().
     *
     * @see self::__construct()
     */
    protected function registerWebhooks(): void
    {
        $webhooks = \array_keys($this->registry->get('app/webhook'));
        foreach ($webhooks as $webhook) {
            $indexes = \array_keys($this->registry->get(
                \sprintf('app/webhook/%s', $webhook)
            ));
            foreach ($indexes as $index) {
                $section = \sprintf('app/webhook/%s/%s', $webhook, $index);
                $registry = $this->registry->newFromKey($section);
                $class = $registry->get('class', null, false);
                if (\is_null($class)) {
                    $class = \sprintf(
                        "\\donbidon\\TunneledWebhooks\\Webhook\\Connector\\%s",
                        $webhook
                    );
                }
                $this->log(
                    \sprintf("Processing '%s'...", $section),
                    __METHOD__
                );
                /**
                 * @var Webhook\Connector\ConnectorInterface
                 */
                $instance = new $class($this, $registry);
                if (!($instance instanceof Webhook\Connector\ConnectorInterface)) {
                    throw new RuntimeException(\sprintf(
                        "Class %s has to implement %s",
                        $class,
                        Webhook\Connector\ConnectorInterface::class
                    ));
                }
                $instance->register();
                $this->webhooks[] = $instance;
            }
        }
    }

    /**
     * Infinite loop.
     *
     * @return void
     *
     * @see self::__construct()
     */
    protected function infiniteLoop(): void
    {
        // $min = 0;
        while (true) {
            /*
            $this->sendMessage(\sprintf(
                "Working for %d minutes...",
                $min++
            ), __METHOD__);
            */
            \sleep(3600);
        }
    }
}
