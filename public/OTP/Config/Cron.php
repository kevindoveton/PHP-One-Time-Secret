<?php
require_once('Database.php');

class Cron {
  private $db;

  function __construct() {
    $this->db = new Database();
  }

  function __destruct() {

  }

  function run() {
    $this->db->clearExpiredPasswords();
  }
}