<?php
/**
 * Tunneling service class for unit testing.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

/** @noinspection PhpMissingParentCallCommonInspection */

namespace donbidon\TunneledWebhooks\Service;

/**
 * Tunneling service class for unit testing.
 *
 * <!-- donbidon.skip -->
 */
class UT_Service extends A_Service
{
    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->runner->sendMessage("", __METHOD__);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $reason
     */
    public function stop($reason = null)
    {
        $this->runner->sendMessage($reason, __METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getURL()
    {
        $this->runner->sendMessage("", __METHOD__);

        return "ServiceURL";
    }
}
