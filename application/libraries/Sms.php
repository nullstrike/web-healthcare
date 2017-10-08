<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms {

  //Gateway connection details
  private $host = '127.0.0.1';
  private $port = '8800';
  private $username = 'admin';
  private $password = 'admin';

  //sms module
  function SendSMS ($phoneNoRecip, $msgText, $schedule) {

      $fp = fsockopen($this->host, $this->port, $errno, $errstr);
      if (!$fp) {
          echo "errno: $errno \n";
          echo "errstr: $errstr\n";
          return $result;
      }

      $getString = "GET /?Phone=" . rawurlencode($phoneNoRecip) . "&Text=" . rawurlencode($msgText) . "&DelayUntil=" . rawurlencode($schedule) . " HTTP/1.0\n";

      fwrite($fp, $getString);
      if ($this->username != "") {
         $auth = $this->username . ":" . $this->password;
         $auth = base64_encode($auth);
         fwrite($fp, "Authorization: Basic " . $auth . "\n");
      }
      fwrite($fp, "\n");

      $res = "";

      while(!feof($fp)) {
          $res .= fread($fp,1);
      }
      fclose($fp);


      return $res;
  }

}
