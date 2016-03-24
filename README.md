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
use Hongliang\Defender\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Defender\Voter\UriKeywordVoter;

$defender = new Defender();
$defender->addVoter(new IpRangeVoter())
    ->addVoter(new UriKeywordVoter());

$defender->react();
```
Customize to your own needs:
```php
use Hongliang\Defender\Defender;
use Hongliang\Defender\Defender\Voter\IpRangeVoter;
use Hongliang\Defender\Defender\Voter\UriKeywordVoter;

// it's possible to customize the level of reaction as the 2nd parameter of addVoter()
// it's possible to set a URL to redirect to when the level is revange or higher. By default it's localhost
$defender = new Defender();
$defender->addVoter(new IpRangeVoter(), Defender::FORBIDDEN)
    ->addVoter(new UriKeywordVoter(), Defender::REVANGE)
    ->setRedirectUrl('http://www.google.com');

$defender->react();
```

## TODO

 - [ ] Support logging and log everything that's above the normal level
 - [ ] Separate IP ranges into separate file or even external rourse
 - [ ] Separate URI keywords into categories, e.g. Wordpress, Joomla. This way it's possible to be used in those CMSes.
