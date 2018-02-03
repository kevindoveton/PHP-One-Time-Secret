<?php
require_once('Controller.php');
require_once(__DIR__ . '/../Config/Database.php');

$hash = RouteController::getSegments();
$db = new Database();

if (count($hash) < 2) {
  die('Routes/GetPassword: Not enough segments');
} else if ($hash[1] == '') {
  die('Routes/GetPassword: Segment 2 is empty');
}

// slow down if env value OTP_SLOW
// this is to slow down anyone
// trying to brute force
if (defined('OTP_SLOW')) {
  sleep(3);
}

if ($hash[1] == 'demo') {
  $pw = 'this-is-test';
} else {
  $pw = $db->getPassword($hash[1]);
}

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
$twig = new Twig_Environment($loader, array());
echo $twig->render('GetPassword.twig', array(
  'password' => $pw,
  'template' => 'GetPassword'
));
