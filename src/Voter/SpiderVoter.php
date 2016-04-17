<?php

namespace Hongliang\Defender\Voter;

class SpiderVoter extends BaseVoter implements VoterInterface
{
    public function vote($spider = null)
    {
        $spiders = $this->getAssets();
        foreach ($spiders as $s) {
            if (false !== strpos($_SERVER['HTTP_USER_AGENT'], $s)) {
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
