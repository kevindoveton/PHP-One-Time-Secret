<?php

class RouteController {
  private $path;
  private $segments = array();

  function __construct() {
    $page = isset($_GET['p']) ? $_GET['p'] : '';
    $this->segments = explode('/', $page);
  }

  function getSegments() {
    return $this->segments;
  }

  function getPage() {
    if (count($this->segments) == 0) {
      die('Route / Controller: No Segments');
    }
    
    switch($this->segments[0]) {
      case 'get':
        require_once('GetPassword.php');
        break;
      default:
        require_once('CreatePassword.php');
    }
  }

}
