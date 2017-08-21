<?php
<<<CONFIG
packages:
    - "twig/twig: ~1.0"
CONFIG;

$loader = new Twig_Loader_Array(array(
    'index' => "Hello {{ name }}!\n",
));

$twig = new Twig_Environment($loader);

echo $twig->render('index', array('name' => 'Melody'));