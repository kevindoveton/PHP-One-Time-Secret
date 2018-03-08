<?php
require_once('dbCredentials.php');
require_once('Encryption.php');
use ioncube\phpOpensslCryptor\Cryptor;

class Database {
  private $writeDb;
  private $readDb;
  private $encryptionKey;

  function __construct() {
    $this->writeDb = null;
    $this->readDb = null;
    $this->encryptionKey = $_ENV['OTP_ENC_KEY'];
  }

  function __destruct() {
    if ($this->writeDb != null) {
      $this->writeDb->close();
    }

    if ($this->readDb != null) {
      $this->readDb->close();
    }
  }

  public function getPassword($code) {
    if ($this->readDb == null) {
      $this->connectRead();
    }

    $getStmt = $this->readDb->prepare("SELECT password FROM passwords WHERE code = ?");
    $getStmt->bind_param("s", $code);
    $getStmt->execute();
    $getStmt->bind_result($result);
    $getStmt->fetch();
    $getStmt->close();

    $deleteStmt = $this->readDb->prepare("DELETE FROM passwords WHERE code = ?");
    $deleteStmt->bind_param("s", $code);
    $deleteResult = $deleteStmt->execute();
    $deleteStmt->close();

    if ($deleteResult && $result != '') {
      $decrypted = Cryptor::Decrypt($result, $this->encryptionKey);
      return $decrypted;
    } else {
      return '';
    }
  }

  public function savePassword($password, $short = false) {
    if ($this->writeDb == null) {
      $this->connectWrite();
    }

    $codeLength = 24;
    if ($short == true) {
      $codeLength = 3;
    }

    $code = bin2hex(openssl_random_pseudo_bytes($codeLength));
    $encPw = Cryptor::Encrypt($password, $this->encryptionKey);

    $insertStmt = $this->writeDb->prepare("INSERT INTO passwords(password, code, expiration) VALUES (?, ?, DATE_ADD(now(), INTERVAL 1 HOUR))");
    $insertStmt->bind_param("ss", $encPw, $code);
    $insertResult = $insertStmt->execute();
    $insertStmt->close();

    if ($insertResult) {
      return $code;
    } else {
      return '';
    }
  }

  public function clearExpiredPasswords() {
    if ($this->writeDb == null) {
      $this->connectWrite();
    }

    $stmt = $this->writeDb->prepare("DELETE FROM `passwords` WHERE `expiration` <= CURDATE() AND `expiration` IS NOT NULL");
    $stmt->execute();
  }

  private function connectWrite() {
    $mysqli = new mysqli(DB_HOST, DB_WRITE_USER, DB_WRITE_PASS, DB);

    if ($mysqli->connect_errno) {
      echo "Failed to connect: " . $mysqli->connect_error;
      die();
    }

    $this->writeDb = $mysqli;

    return;
  }

  private function connectRead() {
    $mysqli = new mysqli(DB_HOST, DB_READ_USER, DB_READ_PASS, DB);

    if ($mysqli->connect_errno) {
      echo "Failed to connect: " . $mysqli->connect_error;
      die();
    }

    $this->readDb = $mysqli;

    return;
  }

}
