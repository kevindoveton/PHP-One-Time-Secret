<?php
require_once(__DIR__ . '/../Config/Database.php');
$data = array();



$loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
$twig = new Twig_Environment($loader, array());
echo $twig->render('Setup.twig', $data);