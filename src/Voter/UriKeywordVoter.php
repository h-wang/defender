<?php

namespace Hongliang\Defender\Voter;

class UriKeywordVoter extends BaseVoter implements VoterInterface
{
    public function vote($uri = null)
    {
        $uri = strtolower($uri ?: $this->target);
        $keywords = $this->getAssets();
        foreach ($keywords as $k) {
            if (false !== strpos($uri, $k)) {
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
            '/filemanager',
            '/bbs',
            '/convert',
            '/product',
            '/plus',
        ];
    }

    /*
    public function setAssets($assets)
    {
        // skip checks for performance
        // if (!is_array($assets)) {
        //     throw new \Exception('Assets of '.static::class.' must be an array');
        // }
        // if (count($assets) != count($assets, COUNT_RECURSIVE)) {
        //     throw new \Exception('Assets of '.static::class.' must be a one-dimensional array');
        // }

        $this->assets = $assets;

        return $this;
    }
    */
}
