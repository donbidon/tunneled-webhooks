<?php
/**
 * Telegram webhook handling I/O class.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Handler\IO;

use donbidon\Core\Registry\I_Registry;
use Telegram\Bot\Api;

/**
 * Telegram webhook handling I/O class.
 *
 * Allows to receive/send messages from/to Telegram service calling webhook.
 * <br />
 * Instance created in <a href="../files/www.com.telegram.bot.windbag.html">Telegram
 * windbag bot</a>.<br />
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 *
 * @link ../files/www.com.telegram.bot.windbag.html  Telegram windbag bot
 */
class Telegram extends IOAbstract
{
    /**
     * Telegram API object
     *
     * @var Api
     */
    protected $api;

    /**
     * Telegram chat Id
     *
     * @var string
     */
    protected $chatId;

    /**
     * {@inheritdoc}
     *
     * @param I_Registry $registry
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function __construct(I_Registry $registry)
    {
        parent::__construct($registry);
        $this->api = new Api($registry->get('token'));
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $options  Options (not used)
     *
     * @return string
     */
    public function receive($options = null): string
    {
        $options; // to shut up code sniffer
        $updates      = $this->api->getWebhookUpdates();
        $this->chatId = $updates['message']['chat']['id'];
        $result       = $updates['message']['text'];

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $response
     * @param array  $options   Telegram API message options
     */
    public function send(string $response, $options = null): void
    {
        $message = [
            'chat_id' => $this->chatId,
            'text'    => $response,
        ];
        if (\var_export($options)) {
            $message += $options;
        }
        $this->api->sendMessage($message);
    }
}
