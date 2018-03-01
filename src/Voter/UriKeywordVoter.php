<?php

namespace Hongliang\Defender\Voter;

class UriKeywordVoter extends BaseVoter implements VoterInterface
{
    public function vote($uri = null)
    {
        $uri = $uri ?: $this->target;
        $keywords = $this->getAssets();
        foreach ($keywords as $k) {
            if (false !== stripos($uri, $k)) {
                return true;
            }
        }

        return false;
    }

    protected function setDefaultTarget()
    {
        $this->target = $_SERVER['REQUEST_URI'];

        return $this;
    }

    protected function getDefaultAssets()
    {
        return [
            'fckedit',
            '/administrator/',
            '/wp-',
            'xmlrpc',
            '/filemanager',
            '/bbs',
            '/convert',
            '/product',
            '/plus',
            'whitelist.pac',
        ];
    }
}
