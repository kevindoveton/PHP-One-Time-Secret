<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

define('OTP_DIR', __DIR__ . '/../' . $_ENV['OTP_DIR']);
if (isset($_ENV['OTP_SLOW']) && $_ENV['OTP_SLOW'] == "true") {
  define('OTP_SLOW', true);
}

// Make sure its not a crawler
// don't want the password being
// shown or deleted by mistake
use Jaybizzle\CrawlerDetect\CrawlerDetect;
$CrawlerDetect = new CrawlerDetect;
if($CrawlerDetect->isCrawler()) {
  include_once(OTP_DIR . "/Routes/Crawler.php");
  die();
}

// We can be semi sure its not a bot 
// at this point
require_once(OTP_DIR . "/Routes/Controller.php");
$route = new RouteController();
$route->getPage();
