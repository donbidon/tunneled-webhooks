<?php
/**
 * ngrok tunneling service.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

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
    public function getURL()
    {
        if (is_null($this->url)) {
            $this->runner->sendMessage("Requesting ngrok service status...", __METHOD__);
            $response = json_decode(
                file_get_contents($this->registry->get('status')),
                true
            );
            if (
                !is_array($response) ||
                !isset($response['tunnels']) ||
                !is_array($response['tunnels']) ||
                !isset($response['tunnels'][0]) ||
                !isset($response['tunnels'][0]['public_url'])
            ) {
                $this->runner->sendError("Cannot parse ngrok service status response", __METHOD__);
            }
            $this->runner->sendMessage("ngrok service status received", __METHOD__);
            $this->url = $response['tunnels'][0]['public_url'];
        }

        return $this->url;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $reason
     */
    public function stop($reason = null)
    {
        $this->url = null;
        parent::stop($reason);
    }
}
