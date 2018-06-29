<?php
/**
 * Starting service and registering webhooks unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\TunneledWebhooks;

use donbidon\Core\Registry\UT_Recursive;

/**
 * Starting service and registering webhooks unit tests.
 */
class Runner_Test extends \PHPUnit\Framework\TestCase
{
    /**
     * Runner tests.
     *
     * @return void
     *
     * @throws \Exception  Risen from UT_Runner::__construct().
     * @covers \donbidon\TunneledWebhooks\Runner::__construct
     * @covers \donbidon\TunneledWebhooks\Runner::registry
     * @covers \donbidon\TunneledWebhooks\Runner::getServiceURL
     * @covers \donbidon\TunneledWebhooks\Runner::sendMessage
     * @covers \donbidon\TunneledWebhooks\Runner::sendError
     * @covers \donbidon\TunneledWebhooks\Service\A_Service::__construct
     * @covers \donbidon\TunneledWebhooks\Service\A_Service::start
     * @covers \donbidon\TunneledWebhooks\Service\A_Service::stop
     * @covers \donbidon\TunneledWebhooks\Service\A_Service::getURL
     */
    public function testRunner()
    {
        ob_start();
        $runner = new UT_Runner(implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, "data", "config.php"]
        ));
        $actual = ob_get_clean();
        $expected = implode(PHP_EOL, [
            "[ note ] [ donbidon\TunneledWebhooks\Service\UT_Service::start ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ Processing 'app/webhook/UT_Webhook_First/firstBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UT_Webhook_First::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ Processing 'app/webhook/UT_Webhook_Second/firstBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UT_Webhook_Second::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Runner::registerWebhooks ] ~ Processing 'app/webhook/UT_Webhook_Second/secondBot'...",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Connector\UT_Webhook_Second::register ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Service\UT_Service::stop ] ~ ",
            "[ ERR  ] [ donbidon\TunneledWebhooks\UT_Runner::infiniteLoop ] ~ ",
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
