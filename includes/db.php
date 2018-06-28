<?php
  $host = 'localhost';
  $user = 'pbgames';
  $pass = 'b3n3931206pr!ce';
  $db = 'pbgames_zencart2';

  $conn = new mysqli($host, $user, $pass, $db);

  if($conn->errno){
    echo $conn->error;
  } else {
    echo "Connected!";
  }
?>
