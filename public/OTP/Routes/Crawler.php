<?php

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
$twig = new Twig_Environment($loader, array());
echo $twig->render('Crawler.twig', array());
