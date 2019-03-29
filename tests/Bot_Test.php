<?php
/**
 * Eebhooks handling unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

/** @noinspection PhpIllegalPsrClassPathInspection */
namespace donbidon\TunneledWebhooks\Webhook\Handler;

use donbidon\Core\ExceptionExtended as ExceptionExtended;
use donbidon\Core\Registry\UT_Recursive;

/**
 * Eebhooks handling unit tests.
 */
class Bot_Test extends \PHPUnit\Framework\TestCase
{
    /**
     * Runner tests.
     *
     * @return void
     *
     * @throws \ReflectionException  Risen from UT_Recursive::_get().
     * @throws ExceptionExtended  Risen from IO\UT_IO::__construct().
     * @covers \donbidon\TunneledWebhooks\\Webhook\Handler\IO\A_IO::__construct
     * @covers \donbidon\TunneledWebhooks\\Webhook\Handler\IO\A_IO::receive
     * @covers \donbidon\TunneledWebhooks\\Webhook\Handler\IO\A_IO::send
     * @covers \donbidon\TunneledWebhooks\\Webhook\Handler\A_Handler::__construct
     * @covers \donbidon\TunneledWebhooks\\Webhook\Handler\A_Handler::run
     */
    public function testWebhooksHandling()
    {
        \donbidon\Core\UT_Bootstrap::initByPath(implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, "data", "config.php"]
        ));
        $registry = new UT_Recursive;

        ob_start();
        $bot = new UT_Handler(new IO\UT_IO($registry));
        $bot->run();
        $actual = ob_get_clean();
        $expected = implode(PHP_EOL, [
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\IO\UT_IO::__construct ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\UT_Handler::__construct ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\UT_Handler::run ] ~ UI external service message",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\IO\UT_IO::send ] ~ UT webhook handler message",
            "",
        ]);
        self::assertEquals($expected, $actual);

        UT_Recursive::resetInstance();
    }
}
