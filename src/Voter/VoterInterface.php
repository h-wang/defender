<?php

namespace Hongliang\Defender\Voter;

interface VoterInterface
{
    public function vote($key);
    public function getAssets();
}
