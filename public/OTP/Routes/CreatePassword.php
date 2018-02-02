<?php
require_once(__DIR__ . '/../Config/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = file_get_contents("php://input");
  $d = json_decode($data, true);

  $db = new Database();
  $pw = isset($d['password']) ? $d['password'] : '';
  $short = isset($d['short']) ? $d['short'] : false;

  if ($pw == '') {
    die('Routes/CreatePassword: Password must be present');
  }

  $code = $db->savePassword($pw, $short);

  $res = (object) [
    'url' => '/get/'.$code,
    'code' => $code
  ];
  echo json_encode($res);
  die();
} else {
  $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
  $twig = new Twig_Environment($loader, array());
  echo $twig->render('CreatePassword.twig', array());
}