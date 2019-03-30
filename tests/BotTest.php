<?php
/**
 * Webhooks handling unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);
/** @noinspection PhpIllegalPsrClassPathInspection */
namespace donbidon\TunneledWebhooks\Webhook\Handler;

use donbidon\Core\ExceptionExtended as ExceptionExtended;
use donbidon\Core\Registry\UT_Recursive;

/**
 * Webhooks handling unit tests.
 */
class BotTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Runner tests.
     *
     * @return void
     *
     * @throws \ReflectionException  Risen from UT_Recursive::_get().
     * @throws ExceptionExtended  Risen from IO\UTIO::__construct().
     *
     * @_covers donbidon\TunneledWebhooks\\Webhook\Handler\IO\IOAbstract::__construct()
     * @_covers donbidon\TunneledWebhooks\\Webhook\Handler\IO\IOAbstract::receive()
     * @_covers donbidon\TunneledWebhooks\\Webhook\Handler\IO\IOAbstract::send()
     * @_covers donbidon\TunneledWebhooks\\Webhook\Handler\HandlerAbstract::__construct()
     * @_covers donbidon\TunneledWebhooks\\Webhook\Handler\HandlerAbstract::run()
     */
    public function testWebhooksHandling(): void
    {
        \donbidon\Core\UT_Bootstrap::initByPath(implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, "data", "config.php"]
        ));
        $registry = new UT_Recursive;

        ob_start();
        $bot = new UTHandler(new IO\UTIO($registry));
        $bot->run();
        $actual = ob_get_clean();
        $expected = implode(PHP_EOL, [
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\IO\UTIO::__construct ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\UTHandler::__construct ] ~ ",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\UTHandler::run ] ~ UI external service message",
            "[ note ] [ donbidon\TunneledWebhooks\Webhook\Handler\IO\UTIO::send ] ~ UT webhook handler message",
            "",
        ]);
        self::assertEquals($expected, $actual);

        UT_Recursive::resetInstance();
    }
}
