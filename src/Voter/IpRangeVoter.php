<?php

namespace Hongliang\Defender\Voter;

use Hongliang\Defender\Utility\IpTools;

class IpRangeVoter extends BaseVoter implements VoterInterface
{
    public function vote($ip = null)
    {
        $ip = $ip ?: $this->target;
        if (!$ip) {
            return false;
        }
        // convert ip to number
        $long = ip2long($ip);
        // get bad ip ranges
        $ips = $this->getAssets();
        foreach ($ips as $ipRange) {
            if ($long <= ip2long($ipRange[1]) && $long >= ip2long($ipRange[0])) {
                return true;
            }
        }

        return false;
    }

    protected function setDefaultTarget()
    {
        $this->target = IpTools::getClientIp();

        return $this;
    }

    protected function getDefaultAssets()
    {
        return [
            ['59.62.0.0', '59.63.255.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['59.172.0.0', '59.173.255.255'], // CHINANET Hubei province network
            ['61.146.178.0', '61.146.178.255'], // MAINT-CHINANET-GD
            ['62.210.0.0', '62.210.255.255'], // IE-POOL-BUSINESS-HOSTING Franch
            ['86.123.0.0', '86.123.255.255'], // RDS Residential ROMANIA
            ['89.122.0.0', '89.122.255.255'], // Romtelecom Data Network Romania
            ['106.4.0.0', '106.7.255.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['115.148.0.0', '115.254.255.255'], // many attempts, just block them all
            ['117.21.0.0', '117.21.255.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['117.41.0.0', '117.41.255.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['146.148.128.0', '146.148.255.255'], // GCHAO LLC
            ['148.251.0.0', '148.251.255.255'], // Hetzner Online GmbH
            ['178.239.165.0', '178.239.165.255'], // COBALT-NETWORKS English
            ['182.96.0.0', '182.111.255.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['218.64.0.0', '218.65.127.255'], // CHINANET JIANGXI PROVINCE NETWORK
            ['202.75.32.0', '202.75.63.254'], // TM VADS DC Hosting
            ['222.208.0.0', '222.215.255.255'], // CHINANET Sichuan province network
        ];
    }

    /*
    public function setAssets($assets)
    {
        if (!is_array($assets)) {
            throw new \Exception(static::class.' assets must be an array');
        }
        $this->assets = $assets;

        return $this;
    }
    */
}
