<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $data = $_GET;
    if(isset($data['id'])){
      $prod = new Product($db);
      $id = $data['id'];
      $results = $prod->getProduct($id);
      if($results){
        $return['status'] = 'ok';
        $return['results'] = $results;
      } else {
        $return['status'] = 'err';
        $return['errors'][] = 'Products not found.';
      }
    } elseif(isset($data['catId'])){
      $prod = new Product($db);
      $catId = $data['catId'];
      $results = $prod->getCategoryProducts($catId);
      if($results){
        $return['status'] = 'ok';
        $return['results'] = $results;
      } else {
        $return['status'] = 'err';
        $return['errors'][] = 'Products not found.';
      }
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Missing product ID';
    }
  }

  echo json_encode($return);
?>
