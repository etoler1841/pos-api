<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  if($return['status'] == 'ok'){
    $prod = new Product($db);
    if(isset($_GET['id']) && isset($_POST['price'])){
      $id = $_GET['id'];
      $price = $_POST['price'];
      $return = $prod->updatePrice($id, $price, $user->storeId);
    } else {
      $return = $prod->getPriceUpdates($user->storeId);
    }
  }

  echo json_encode($return);
?>
