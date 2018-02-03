<?php
require_once('../../../vendor/autoload.php');
date_default_timezone_set('Australia/Adelaide');
require_once('./include/Server.php');

$dir = getcwd();
$scssPath = $dir.'/../scss/';
$scssMainFile = $scssPath . 'styles.scss';
$scssOuput = $dir.'/temp/out.css';

if (file_exists($scssOuput)) {
    unlink($scssOuput);
}

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Server;

$scss = new Compiler();
$scss->addImportPath($scssPath);
if (!IS_DEV) {
    $scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
}
if (IS_DEV) {
    $scss->setSourceMap(Compiler::SOURCE_MAP_INLINE);
    $scss->setSourceMapOptions([
        'sourceMapBasepath' => $scssPath,
        'sourceMapRootpath' => '/common/scss/'
    ]);
}

$server = new Server('temp', null, $scss);

echo $server->checkedCachedCompile($scssMainFile, $scssOuput);