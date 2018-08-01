<?php
  require 'includes/includes.php';

  $user = new User($db);
  $return = $user->authorize();
  $return['results'] = array();
  if($return['status'] == 'ok'){
    $data = $_GET;
    if(isset($data['id'])){
      $prod = new Product($db);
      $id = $data['id'];
      $results = $prod->getProduct($id);
      $return['results'] = $results;
    } elseif(isset($data['catId'])){
      $prod = new Product($db);
      $catId = $data['catId'];
      $params = array(
        'limit' => (isset($data['limit']) && $data['limit'] >= 1) ? (int)$data['limit'] : 100,
        'offset' => (isset($data['offset']) && $data['offset'] >= 0) ? (int)$data['offset'] : 0,
        'before' => (isset($data['before'])) ? date('Y-m-d H:i:s', $data['before']) : date('Y-m-d H:i:s', strtotime('now')),
        'after' => (isset($data['after'])) ? date('Y-m-d H:i:s', $data['after']) : date('Y-m-d H:i:s', 0),
      );
      if($params['limit'] > 100) $params['limit'] = 100;
      $return['results'] = $prod->getCategoryProducts($catId, $params);
    } elseif(isset($data['getAll'])){
      $prod = new Product($db);
      $params = array(
        'limit' => (isset($data['limit']) && $data['limit'] >= 1) ? (int)$data['limit'] : 100,
        'offset' => (isset($data['offset']) && $data['offset'] >= 0) ? (int)$data['offset'] : 0,
        'before' => (isset($data['before'])) ? date('Y-m-d H:i:s', $data['before']) : date('Y-m-d H:i:s', strtotime('now')),
        'after' => (isset($data['after'])) ? date('Y-m-d H:i:s', $data['after']) : date('Y-m-d H:i:s', 0),
      );
      if($params['limit'] > 100) $params['limit'] = 100;
      $return['results'] = $prod->getAllProducts($params);
    } else {
      $return['status'] = 'err';
      $return['errors'][] = 'Missing product ID';
    }
  }

  echo json_encode($return);
?>
