<?php
<<<CONFIG
packages:
    - "vdb/php-spider"
    - "symfony/event-dispatcher"
CONFIG;

use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use Symfony\Component\EventDispatcher\Event;
use VDB\Spider\Event\SpiderEvents;
use VDB\Spider\StatsHandler;
use VDB\Spider\Spider;


// tick use required as of PHP 4.3.0
declare(ticks = 1);

// signal handler function
function sig_handler($signo)
{

     switch ($signo) {
         case SIGTERM:
             // handle shutdown tasks
             echo "caught SIGTERM";
             exit;
             break;
         case SIGHUP:
             // handle restart tasks
             break;
         case SIGUSR1:
             echo "Caught SIGUSR1...\n";
             break;
         default:
             // handle all other signals
     }

}

echo "Installing signal handler...\n";

// setup signal handlers
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP,  "sig_handler");
pcntl_signal(SIGUSR1, "sig_handler");

function done()
{
  // or use an object, available as of PHP 4.3.0
  // pcntl_signal(SIGUSR1, array($obj, "do_something"));

  echo"Generating signal SIGUSR1 to self...\n";

  // send SIGUSR1 to current process id
  // posix_* functions require the posix extension
  posix_kill(posix_getpid(), SIGUSR1);

  echo "Done\n";
}

// Create Spider
$spider = new Spider('http://dmoztools.net');
// Add a URI discoverer. Without it, the spider does nothing. In this case, we want <a> tags from a certain <div>
$spider->getDiscovererSet()->set(new XPathExpressionDiscoverer("//div[@id='catalogs']//a"));
// Set some sane options for this example. In this case, we only get the first 10 items from the start page.
$spider->getDiscovererSet()->maxDepth = 1;
$spider->getQueueManager()->maxQueueSize = 10;
// Let's add something to enable us to stop the script
$spider->getDispatcher()->addListener(
    SpiderEvents::SPIDER_CRAWL_USER_STOPPED,
    function (Event $event) {
        echo "\nCrawl aborted by user.\n";
        //done();
        //exit();
    }
);
// Add a listener to collect stats to the Spider and the QueueMananger.
// There are more components that dispatch events you can use.
$statsHandler = new StatsHandler();
$spider->getQueueManager()->getDispatcher()->addSubscriber($statsHandler);
$spider->getDispatcher()->addSubscriber($statsHandler);
// Execute crawl
$spider->crawl();
// Build a report
echo "\n  ENQUEUED:  " . count($statsHandler->getQueued());
echo "\n  SKIPPED:   " . count($statsHandler->getFiltered());
echo "\n  FAILED:    " . count($statsHandler->getFailed());
echo "\n  PERSISTED:    " . count($statsHandler->getPersisted());
// Finally we could do some processing on the downloaded resources
// In this example, we will echo the title of all resources
echo "\n\nDOWNLOADED RESOURCES: ";
foreach ($spider->getDownloader()->getPersistenceHandler() as $resource) {
    echo "\n - " . $resource->getCrawler()->filterXpath('//title')->text();
}

sleep(3600);
