<?php
  class Product {
    function __construct($db){
      $this->db = $db;
    }

    function getProduct($id){
      $db = $this->db;

      $sql = "SELECT pd.products_name, p.products_quantity, p.products_model, p.products_price, p.master_categories_id
              FROM products p
              LEFT JOIN products_description pd ON p.products_id = pd.products_id
              WHERE p.products_id = $id";
      $result = $db->query($sql);
      $return = array();
      if($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        extract($row);
        $return[] = array(
          'products_id' => (int)$id,
          'products_name' => $products_name,
          'products_quantity' => (int)$products_quantity,
          'products_model' => $products_model,
          'products_price' => $products_price,
          'categories_id' => (int)$master_categories_id
        );
      }

      return $return;
    }

    function getCategoryProducts($catId, $params){
      $db = $this->db;

      $sql = "SELECT p.products_id, pd.products_name, p.products_quantity, p.products_model, p.products_price, p.master_categories_id
              FROM products p
              LEFT JOIN products_description pd ON p.products_id = pd.products_id
              WHERE p.master_categories_id = $catId
              AND p.products_date_added <= '".$params['before']."'
              AND p.products_date_added >= '".$params['after']."'
              ORDER BY p.products_id ASC
              LIMIT ".$params['offset'].", ".$params['limit'];
      $res = $db->query($sql);
      $return = array();
      if($res->num_rows){
        while($row = $res->fetch_array(MYSQLI_ASSOC)){
          extract($row);
          $return[] = array(
            'products_id' => (int)$products_id,
            'products_name' => $products_name,
            'products_quantity' => (int)$products_quantity,
            'products_model' => $products_model,
            'products_price' => $products_price,
            'categories_id' => (int)$master_categories_id
          );
        }
      }

      return $return;
    }
  }
