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
    $return['errors'][] = 'Missing category ID';
    echo json_encode($return);
    exit();
  }
  $prod = new Category($conn);
  $id = $data['id'];
  $results = $prod->getLabels($id);
  if($results){
    $return['status'] = 'ok';
    $return['results'] = $results;
  } else {
    $return['status'] = 'err';
    $return['errors'][] = 'Category not found.';
  }

  echo json_encode($return);
?>
