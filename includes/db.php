<?php
  $host = 'localhost';
  $user = 'pbgames';
  $pass = 'b3n3931206pr!ce';
  $db = 'pbgames_zencart2';

  $conn = new mysqli('148.72.29.202', 'pbgames_test', 'b3n3931206pr!ce', 'pbgames_testing_db');

  if($conn->errno){
    echo $conn->error;
  }
?>
