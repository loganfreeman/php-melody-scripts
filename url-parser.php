<?php
<<<CONFIG
packages:
    - "jeremykendall/php-domain-parser: ~2.0"
    - "jwage/purl"
CONFIG;

use Pdp\PublicSuffixListManager;
use Pdp\Parser;

$pslManager = new Pdp\PublicSuffixListManager();
$parser = new Pdp\Parser($pslManager->getList());
$host = 'http://user:pass@www.pref.okinawa.jp:8080/path/to/page.html?query=string#fragment';
$url = $parser->parseUrl($host);
var_dump($url);


$url = \Purl\Url::parse('http://jwage.com')
	->set('scheme', 'https')
	->set('port', '443')
	->set('user', 'jwage')
	->set('pass', 'password')
	->set('path', 'about/me')
	->set('query', 'param1=value1&param2=value2')
	->set('fragment', 'about/me?param1=value1&param2=value2');

echo $url->getUrl();
