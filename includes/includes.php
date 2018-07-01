<?php
  header("Content-type: Application/json");
  error_reporting(0);
  require 'db.php';

  foreach(glob('includes/classes/*') as $file){
    include $file;
  }
?>
