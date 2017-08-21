<?php

<<<CONFIG
packages:
    - "league/flysystem: *"
CONFIG;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

$adapter = new Local(__DIR__);
$filesystem = new Filesystem($adapter);

$contents = $filesystem->listContents('.', true);

print_r($contents);
