[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/h-wang/defender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/h-wang/defender/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/h-wang/defender/badges/build.png?b=master)](https://scrutinizer-ci.com/g/h-wang/defender/build-status/master)

# Defender
Defend your site from malicious scans.
It works with defense voters. Currently request URI keyword and IP range defense voters are supported.

## Installation
Install via composer
```
composer require hongliang/defender
```
## How it works

If you are running a Silex or Symfony application, the following code should be injected after the autoload but before the routers. Otherwise it will trigger an undefined route exception.

The simple way:
```php
\Hongliang\Defender\Defender::defend();
```
The customized way:
```php
use Hongliang\Defender\Defender;
use Hongliang\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Voter\UriKeywordVoter;

$defender = new Defender();
$defender->addVoter(new IpRangeVoter())
    ->addVoter(new UriKeywordVoter())
    ->react();
```
Customize to your own needs:
```php
use Hongliang\Defender\Defender;
use Hongliang\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Voter\UriKeywordVoter;
use Hongliang\Defender\Voter\SpiderVoter;

// it's possible to customize the level of reaction as the 2nd parameter of addVoter()
// it's possible to set a URL to redirect to when the level is revenge or higher. By default it's localhost
$defender = new Defender();
$defender->addVoter(new IpRangeVoter(), Defender::FORBIDDEN)
    ->addVoter(new UriKeywordVoter(), Defender::REVENGE)
    ->addVoter(new SpiderVoter(), Defender::DENY)
    ->setRedirectUrl('http://www.google.com')
    ->react();
```
More advanced use:
```php
use Hongliang\Defender\Defender;
use Hongliang\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Voter\UriKeywordVoter;
use Hongliang\Defender\Voter\SpiderVoter;

$voter = new UriKeywordVoter();
$voter->setAssets(['fckedit', '/wp-']);
$ipVoter = new IpRangeVoter();
$ipVoter->setAssets([['0.0.0.0', '255.255.255.255']]);

$spiderVoter = new SpiderVoter();
$spiderVoter->setAssets(['Baiduspider', '360spider']);

$defender = new Defender();
$defender->addVoter($ipVoter, Defender::FORBIDDEN)
    ->addVoter($voter, Defender::DENY)
    ->addVoter($spiderVoter, Defender::DENY)
    ->react();
```


## TODO
 - [x] Separate IP ranges into separate file or even external resource
 - [ ] Support logging and log everything that's above the normal level
 - [ ] Separate URI keywords into categories, e.g. Wordpress, Joomla. This way it's possible to be used in those CMSes.
