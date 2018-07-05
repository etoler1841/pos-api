<?php
  require 'includes/includes.php';
  $data = json_decode(file_get_contents("php://input"), true);
  $return = array(
    'status' => '',
    'errors' => array(),
    'results' => array()
  );
  if(isset($data['token'])){
    $user = new User($db);
    if($user->authorize($data['authId'], $data['authToken'])){
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
    $return['errors'][] = 'Missing authorization token';
  }

  echo json_encode($return);
?>
