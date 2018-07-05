<?php
  require 'includes/includes.php';
  $auth = json_decode(file_get_contents("php://input"), true);
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
