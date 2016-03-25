<?php

namespace Hongliang\Defender\Voter;

class BaseVoter implements VoterInterface
{
    protected $assets = null;
    protected $target = null;

    public function __construct()
    {
        if (method_exists($this, 'setDefaultTarget')) {
            $this->setDefaultTarget();
        }
        if (method_exists($this, 'getDefaultAssets')) {
            $this->assets = $this->getDefaultAssets();
        }
    }

    public function vote($key = null)
    {
        throw new \Exception('The vote method must be implemented in '.static::class);
    }

    protected function getAssets()
    {
        return $this->assets;
    }

    public function setAssets($assets)
    {
        $this->assets = $assets;

        return $this;
    }
}
