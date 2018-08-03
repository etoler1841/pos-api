<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  if($return['status'] == 'ok'){
    $prod = new Product($db);
    if(isset($_GET['id']) && isset($_POST['qty'])){
      $id = $_GET['id'];
      $qty = $_POST['qty'];
      $return = $prod->updateQty($id, $qty, $user->storeId);
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Missing parameter.';
      exit(json_encode($return));
    }
  }

  echo json_encode($return);
?>
