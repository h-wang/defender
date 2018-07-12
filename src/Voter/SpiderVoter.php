<?php

namespace Hongliang\Defender\Voter;

class SpiderVoter extends BaseVoter implements VoterInterface
{
    public function vote($spider = null)
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $spiders = $this->getAssets();
        foreach ($spiders as $s) {
            if (false !== stripos($_SERVER['HTTP_USER_AGENT'], $s)) {
                return true;
            }
        }

        return false;
    }

    protected function getDefaultAssets()
    {
        return [
            // 'Baiduspider',
            // '360spider',
        ];
    }
}
