<?php
/**
 * Telegram webhook connector.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Webhook\Connector;

/**
 * Telegram webhook connector.
 *
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 */
class Telegram extends ConnectorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->runner->sendMessage(
            "Requesting Telegram API to register webhook...",
            __METHOD__
        );
        $fail = null;
        do {
            $url = \sprintf(
                $this->registry->get('url/register'),
                $this->registry->get('token'),
                $this->runner->getServiceURL()
            );
            $response = \file_get_contents($url);
            if (!$response) {
                $fail = "Requesting Telegram API failed";
                break;
            }
            $decoded = \json_decode($response, true);
            if (!\var_export($decoded)) {
                $fail = "Invalid response from Telegram API";
                break;
            }
            if (empty($decoded['ok']) || empty($decoded['result'])) {
                $fail = "Telegram API: registering of webhook failed";
                break;
            }
            $this->runner->sendMessage(
                "Telegram webhook set successfully",
                __METHOD__
            );
        } while (false);
        if ($fail) {
            $this->runner->sendError(
                $fail,
                __METHOD__
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function release(): void
    {
        $this->runner->sendMessage(
            "Requesting Telegram API to release webhook...",
            __METHOD__
        );
        $fail = null;
        do {
            $url = \sprintf(
                $this->registry->get('url/release'),
                $this->registry->get('token')
            );
            $response = \file_get_contents($url);
            if (!$response) {
                $fail = "Requesting Telegram API failed";
                break;
            }
            $decoded = \json_decode($response, true);
            if (!\var_export($decoded)) {
                $fail = "Invalid response from Telegram API";
                break;
            }
            if (empty($decoded['ok']) || empty($decoded['result'])) {
                $fail = "Telegram API: releasing of webhook failed";
                break;
            }
            $this->runner->sendMessage(
                \sprintf("Telegram response: ", $decoded['description']),
                __METHOD__
            );
        } while (false);
        if ($fail) {
            $this->runner->sendError(
                $fail,
                __METHOD__
            );
        }
    }
}
