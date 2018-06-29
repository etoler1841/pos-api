<?php
  require 'includes/includes.php';
  $data = $_GET;
  $cat = new Category($conn);
  $id = (isset($data['id'])) ? $data['id'] : 0;
  $results = $cat->getCategoryTree($id);
  if($results){
    $return['status'] = 'ok';
    $return['results'] = $results;
  } else {
    $return['status'] = 'err';
    $return['errors'][] = 'Categories not found.';
  }

  echo json_encode($return);
?>
