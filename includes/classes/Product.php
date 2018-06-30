<?php
  class Product {
    function __construct($db){
      $this->db = $db;
    }

    function getProduct($id){
      $db = $this->db;

      $sql = "SELECT pd.products_name, p.master_categories_id
              FROM products p
              LEFT JOIN products_description pd ON p.products_id = pd.products_id
              WHERE p.products_id = $id";
      $row = $db->query($sql)->fetch_array(MYSQLI_ASSOC);
      extract($row);
      $return[] = array(
        'products_id' => (int)$id,
        'products_name' => $products_name,
        'categories_id' => (int)$master_categories_id
      );

      return $return;
    }
  }
