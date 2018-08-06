<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $prod = new Product($db);
    $results = $prod->dlQueue($user->storeId);
    $return['results'] = $results;
  }

  echo json_encode($return);
?>
