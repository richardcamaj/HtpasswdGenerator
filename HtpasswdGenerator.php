<?php
/**
 * HtpasswordGenerator - easy way to lock folders under Apache web server
 *
 * Copyright (c) Richard Camaj
 * Licensed under the MIT (file: LICENSE)
 * 
 * @name HtpasswordGenerator
 * @author Richard Camaj <richard.camaj@gmail.com>
 * @copyright Richard Camaj <richard.camaj@gmail.com>
 * @license MIT
 * @version 1.0.1
 */
class HtpasswdGenerator {
   /**
    * @function apr1Md5
    * APR1-MD5 encryption for passwords
    * @param {string} $str - password in plaintext
    */
   private function apr1Md5($str) {
      $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
      $len  = strlen($str);
      $text = $str . '$apr1$' . $salt;
      $bin  = pack("H32", md5($str . $salt . $str));
      
      for ($i = $len; $i > 0; $i -= 16) {
         $text .= substr($bin, 0, min(16, $i));
      }
      
      for ($i = $len; $i > 0; $i >>= 1) {
         $text .= ($i & 1) ? chr(0) : $str{0};
      }
      
      $bin = pack("H32", md5($text));
      
      for ($i = 0; $i < 1000; $i++) {
         $new = ($i & 1) ? $str : $bin;
         if ($i % 3)
            $new .= $salt;
         if ($i % 7)
            $new .= $str;
         $new .= ($i & 1) ? $bin : $str;
         $bin = pack("H32", md5($new));
      }
      
      for ($i = 0; $i < 5; $i++) {
         $k = $i + 6;
         $j = $i + 12;
         if ($j == 16)
            $j = 5;
         $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
      }
      
      $tmp = chr(0) . chr(0) . $bin[11] . $tmp;
      $tmp = strtr(strrev(substr(base64_encode($tmp), 2)), 
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", 
      "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
      
      return "$" . "apr1" . "$" . $salt . "$" . $tmp;
   }
   
   /**
    * @function generateHtpasswd
    * Generate Htpasswd content with a specific username and password
    * @param {string} $username - username in plaintext string
    * @param {string} $password - password in plaintext string
    * @return {string}
    */
   public function generateHtpasswd($username, $password) {
      $pwd = $this->apr1Md5($password);
      return $username . ':' . $pwd;
   }
   
   /**
    * @function getHtaccessPart
    * Generate Htaccess for folder / path encryption
    * @param {string} $pathToHtpasswdFile - path to .htpasswd file
    * @param {string} $message - name of protected area
    * @return {string}
    */
   public function getHtaccessPart($pathToHtpasswdFile = "/path/to/.htpasswd", $message = "Protected Area") {
      $tmp = "AuthType Basic\n
                AuthName \"$message\"\n
                AuthUserFile $pathToHtpasswdFile\n
                Require valid-user\n";
      return $tmp;
   }
   
   /**
    * @function getHtaccessPartHtml
    * Generate Htaccess file content (in HTML to use on a web page, etc.) to encrypt folder / path
    * @param {string} $pathToHtpasswdFile - path to .htpasswd file
    * @param {string} $message - name of protected area
    * @return {string}
    */
   public function getHtaccessPartHtml($pathToHtpasswdFile = "/path/to/.htpasswd", $message = "Protected Area") {
      $tmp = "AuthType Basic<br>
                AuthName \"$message\"<br>
                AuthUserFile $pathToHtpasswdFile<br>
                Require valid-user<br>";
      return $tmp;
   }
}
?>
