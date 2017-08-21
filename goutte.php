<?php
<<<CONFIG
packages:
    - "fabpot/goutte"
CONFIG;

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'https://wildlife.utah.gov/hotspots/reports_nr.php');

// Get the latest post in this category and display the titles
$crawler->filter('.report2')->each(function ($node) {
    print "\033[31m" .$node->filter('h4 a')->text() . "\033[0m\n";
    print $node->text()."\n\n";
});
