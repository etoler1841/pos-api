<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $data = $_GET;
    $cat = new Category($db);
    $id = (isset($data['id'])) ? $data['id'] : 0;
    if(isset($data['tree']) && $data['tree'] == 0){
      $results = $cat->getCategory($id);
    } else {
      $results = $cat->getCategoryTree($id);
    }
    if($results){
      $return['status'] = 'ok';
      $return['results'] = $results;
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Category not found.';
    }
  }

  echo json_encode($return);
?>
