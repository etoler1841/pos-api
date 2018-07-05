<?php
  require 'includes/includes.php';
  $auth = json_decode(file_get_contents("php://input"), true);
  $data = $_GET;
  $return = array(
    'status' => '',
    'errors' => array(),
    'results' => array()
  );
  if(isset($data['authToken']) && isset($data['authId'])){
    $user = new User($db);
    if($user->authorize($auth['authId'], $auth['authToken'])){
      $cat = new Category($conn);
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
        $return['errors'][] = 'Categories not found.';
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
