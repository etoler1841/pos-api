<?php
  require 'includes/includes.php';
  $data = $_GET;
  $return = array(
    'status' => '',
    'errors' => array(),
    'results' => array()
  );
  if(!isset($data['id'])){
    $return['status'] = 'err';
    $return['errors'][] = 'Missing product ID';
    echo json_encode($return);
    exit();
  }
  $prod = new Product($conn);
  $id = $data['id'];
  $results = $prod->getProduct($id);
  if($results){
    $return['status'] = 'ok';
    $return['results'] = $results;
  } else {
    $return['status'] = 'err';
    $return['errors'][] = 'Products not found.';
  }

  echo json_encode($return);
?>
