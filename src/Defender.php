<?php

namespace Hongliang\Defender;

use Hongliang\Defender\Voter\VoterInterface;
use Hongliang\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Voter\UriKeywordVoter;
use Hongliang\Defender\Voter\SpiderVoter;

class Defender
{
    const NORMAL = 0;
    const NOTICE = 1;
    const FORBIDDEN = 2;
    const DENY = 3;
    const REVENGE = 4;
    const REVENGE_PERMANENT = 5;

    private $voters = null;
    private $redirectUrl = 'http://localhost';

    public static function defend()
    {
        $defender = new self();
        $defender->addVoter(new IpRangeVoter(), self::DENY)
            ->addVoter(new UriKeywordVoter(), self::FORBIDDEN)
            ->addVoter(new SpiderVoter(), self::DENY)
            ->react();
    }

    public function addVoter(VoterInterface $voter, $level = self::FORBIDDEN)
    {
        if (null === $this->voters) {
            $this->voters = [];
        }
        $this->voters [] = ['voter' => $voter, 'level' => $level];

        return $this;
    }

    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;

        return $this;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function exam()
    {
        $level = self::NORMAL;
        if (null === $this->voters) {
            return $level;
        }
        $this->sortVoters();
        foreach ($this->voters as $voter) {
            if ($voter['voter']->vote()) {
                return $voter['level'];
            }
        }

        return $level;
    }

    private function sortVoters()
    {
        if (is_array($this->voters)) {
            usort($this->voters, array($this, 'sortVotersFunc'));
        }
    }

    private function sortVotersFunc($a, $b)
    {
        return $a['level'] < $b['level'];
    }

    public function react($level = null)
    {
        if (null === $level) {
            $level = $this->exam();
        }
        $exit = false;
        switch ($level) {
            case self::REVENGE_PERMANENT:
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$this->getRedirectUrl());
                $exit = true;
                break;
            case self::REVENGE:
                header('HTTP/1.1 302 Moved Temporarily');
                header('Location: '.$this->getRedirectUrl());
                $exit = true;
                break;
            case self::DENY:
                header('HTTP/1.1 500 Internal Server Error');
                $exit = true;
                break;
            case self::FORBIDDEN:
                header('HTTP/1.0 403 Forbidden');
                $exit = true;
                break;
            case self::NOTICE:
            default:
                break;
        }

        if ($exit) {
            exit;
        }
    }
}
