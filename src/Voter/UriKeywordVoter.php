<?php

namespace Hongliang\Defender\Voter;

class UriKeywordVoter implements VoterInterface
{
    private $assets = null;
    private $target = null;

    public function init()
    {
        $this->target = $_SERVER['REQUEST_URI'];

        return $this;
    }

    public function vote($keyword = null)
    {
        $keyword = strtolower($keyword ?: $this->target);
        // get bad ip ranges
        $keywords = $this->getAssets();
        foreach ($keywords as $k) {
            if (false !== strpos($keyword, $k)) {
                return true;
            }
        }

        return false;
    }

    public function getAssets()
    {
        if (null === $this->assets) {
            $this->assets = $this->getDefaultAssets();
        }

        return $this->assets;
    }

    private function getDefaultAssets()
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
}
