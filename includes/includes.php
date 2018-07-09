<?php
  header("Content-type: Application/json");
  error_reporting(0);
  require 'db.php';

  include 'apache_request_headers.php';

  foreach(glob('includes/classes/*') as $file){
    include $file;
  }
?>
