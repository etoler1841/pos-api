<?php
  require 'includes/includes.php';
  print_r($_GET);

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $data = $_GET;
    $cat = new Category($db);
    if(isset($data['id'])){
      $id = $data['id'];
      if(isset($data['tree']) && $data['tree'] == 1){
        $results = $cat->getCategoryTree($id);
      } else {
        $results = $cat->getCategory($id);
      }
    } elseif(isset($data['parentId'])){
      $parent = $data['parentId'];
      $params = array(
        'limit' => (isset($data['limit']) && $data['limit'] >= 1) ? (int)$data['limit'] : 100,
        'offset' => (isset($data['offset']) && $data['offset'] >= 0) ? (int)$data['offset'] : 0
      );
      if($params['limit'] > 100) $params['limit'] = 100;
      $results = $cat->getCategoriesByParent($parent, $params);
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Missing parameter.';
      exit(json_encode($return));
    }
    $return['results'] = $results;
  }

  echo json_encode($return);
?>
