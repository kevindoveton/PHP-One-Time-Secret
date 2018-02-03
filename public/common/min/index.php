<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Australia/Adelaide');

define('IS_DEV', isset($_GET['dev']));

$JS = isset($_GET['js']);
$CSS = !$JS;

if (!file_exists('temp')) {
  mkdir('temp');
}

if ($JS) {
  header("Content-type: application/javascript", true);
  require_once('js.php');
} else {
  header("Content-type: text/css", true);
  require_once('css.php');
}