<?php
  require 'includes/includes.php';
  $data = $_GET;
  $cat = new Category($conn);
  if(isset($data['id'])){
    $results = $cat->getCategoryById($data['id']);
  } elseif(isset($data['tree'])){
    $results = $cat->getCategoryTree($data['tree']);
  } else {
    $results = $cat->getAllCategories();
  }
  if($results){
    $return['status'] = 'ok';
    $return['results'] = $results;
  } else {
    $return['status'] = 'err';
    $return['errors'][] = 'Categories not found.';
  }

  echo json_encode($return);
?>
