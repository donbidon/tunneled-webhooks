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
class ngrok extends A_Service
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
            $response = file_get_contents($this->registry->get('status'));
            if (!preg_match(
                "/" . preg_quote('\\"URL\\":\\"') . "([^\\\]+)/",
                $response,
                $matches
            )) {
                $this->runner->sendError("Cannot parse ngrok service status response", __METHOD__);
            }
            $this->runner->sendMessage("ngrok service status received", __METHOD__);
            $this->url = $matches[1];
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
