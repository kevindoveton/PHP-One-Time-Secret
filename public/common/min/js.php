<?php
$files = array(
  'clipboard.js',
  'init.js'
);

$dir = getcwd();
$baseDir = $dir.'/../js/';


require_once('../../../vendor/autoload.php');
use MatthiasMullie\Minify;


$minifier = new Minify\JS();

foreach($files as $file) {
  $f = $baseDir.$file;
  if (file_exists($f)) {
    $minifier->add($f);
  } else if (IS_DEV) {
    die('missing file '.$f);
  }
}

// save minified file to disk
$minifiedPath = $dir.'/temp/min.js';

if (IS_DEV) {
  foreach($files as $file) {
    $f = $baseDir.$file;
    echo '/** ' . $f . ' **/' . "\n";
    echo file_get_contents($f) . "\n\n\n";
  }
} else {
  $minifier->minify($minifiedPath);
  echo file_get_contents($minifiedPath);
}
