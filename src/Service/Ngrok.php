<?php
/**
 * ngrok tunneling service.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\TunneledWebhooks\Service;

/**
 * ngrok tunneling service.
 *
 * See <a role="button" href="#source-view" data-toggle="modal"><i>source code</i></a>.
 */
class Ngrok extends ServiceAbstract
{
    /**
     * Service URL
     *
     * @var string
     */
    protected $url;

    /**
     * {@inheritdoc}
     */
    public function getURL(): string
    {
        if (\is_null($this->url)) {
            $this->runner->sendMessage("Requesting ngrok service tunnels...", __METHOD__);
            $response = \file_get_contents($this->registry->get('status'));
            $decoded = \json_decode(
                $response,
                true
            );
            if (!\var_export($decoded)) {
                $this->runner->sendError(
                    \sprintf("Cannot parse ngrok service tunnels response: %s", $response),
                    __METHOD__
                );
            }
            if (!isset($decoded['tunnels']) || !\var_export($decoded['tunnels'])) {
                $this->runner->sendError(
                    \sprintf(
                        "Invalid ngrok service tunnels response:%s%s",
                        \var_export($decoded, true)
                    ),
                    __METHOD__
                );
            }
            if (!isset($decoded['tunnels'][0]) || !isset($decoded['tunnels'][0]['public_url'])) {
                $this->runner->sendError(
                    \sprintf(
                        "Empty ngrok service tunnels response:%s%s",
                        \PHP_EOL,
                        \var_export($decoded, true)
                    ),
                    __METHOD__
                );
            }
            $this->runner->sendMessage("ngrok service tunnels received", __METHOD__);
            $this->url = $decoded['tunnels'][0]['public_url'];
        }

        return $this->url;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $reason
     */
    public function stop(?string $reason = null): void
    {
        $this->url = null;
        parent::stop($reason);
    }
}
