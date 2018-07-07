<?php
  require 'includes/includes.php';
  $auth = $_POST;
  $data = $_GET;
  $return = array(
    'status' => '',
    'errors' => array(),
    'results' => array()
  );
  if(isset($auth['authToken']) && isset($auth['authId'])){
    $user = new User($db);
    if($user->authorize($auth['authId'], $auth['authToken'])){
      if(isset($data['id'])){
        $prod = new Category($db);
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
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Authorization token rejected';
    }
  } else {
    $return['status'] = 'err';
    $return['errors'][] = 'Missing authorization params';
  }

  echo json_encode($return);
?>
