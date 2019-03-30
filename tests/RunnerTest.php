<?php
/**
 * Starting service and registering webhooks unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks;

use donbidon\Core\Registry\UT_Recursive;

/**
 * Starting service and registering webhooks unit tests.
 */
class RunnerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Runner tests.
     *
     * @return void
     *
     * @throws \Exception  Risen from UTRunner::__construct().
     *
     * @covers donbidon\TunneledWebhooks\Runner::__construct()
     * @covers donbidon\TunneledWebhooks\Runner::getServiceURL()
     * @covers donbidon\TunneledWebhooks\Runner::sendMessage()
     * @covers donbidon\TunneledWebhooks\Runner::sendError()
     * @covers donbidon\TunneledWebhooks\Service\ServiceAbstract::__construct()
     * @covers donbidon\TunneledWebhooks\Service\ServiceAbstract::start()
     * @covers donbidon\TunneledWebhooks\Service\ServiceAbstract::stop()
     * @covers donbidon\TunneledWebhooks\Service\ServiceAbstract::getURL()
     */
    public function testRunner(): void
    {
        ob_start();
        $runner = new UTRunner(implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, "data", "config.php"]
        ));
        $actual = ob_get_clean();
        $expected = implode(PHP_EOL, [
            "[ note ] [ donbidon\TunneledWebhooks\Service\UTService::start ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ " .
                "Processing 'app/webhook/UTWebhookFirst/firstBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UTWebhookFirst::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ " .
                "Processing 'app/webhook/UTWebhookSecond/firstBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UTWebhookSecond::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ " .
                "Processing 'app/webhook/UTWebhookSecond/secondBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UTWebhookSecond::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Service\UTService::stop ] ~ ",
            "[ ERR  ] [ donbidon\TunneledWebhooks\UTRunner::infiniteLoop ] ~ ",
            "",
        ]);
        self::assertEquals($expected, $actual);

        UT_Recursive::_get('core/event/manager')
            ->fire(':updateLogRegistry:', new \donbidon\Core\Event\Args([
                'conditions' => [],
                'changes' => [
                    'source' => [],
                ],
            ]));
        $actual = $runner->getServiceURL();
        $expected = "ServiceURL";
        self::assertEquals($expected, $actual);

        UT_Recursive::resetInstance();
    }
}
