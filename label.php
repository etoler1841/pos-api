<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $data = $_GET;
    if(isset($data['id'])){
      $cat = new Category($db);
      $id = $data['id'];
      $results = $prod->getLabels($id);
      if($results){
        $return['status'] = 'ok';
        $return['results'] = $results;
      } else {
        $return['status'] = 'err';
        $return['errors'][] = 'Category not found.';
      }
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Missing category ID';
    }
  }

  echo json_encode($return);
?>
