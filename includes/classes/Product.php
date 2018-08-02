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

    function updateQty($id, $qty, $storeId){
      $db = $this->db;

      if($db->error){
        $return = array(
          'status' => 'err',
          'errors' => array(
            $db->error
          )
        );
        return $return;
      } else {
        $return = array(
          'status' => 'ok',
          'errors' => array()
        );
      }

      if($storeId === 1){
        $sql = "UPDATE products
                SET products_quantity = products_quantity + $qty
                WHERE products_id = $id";
      } else {
        $sql = "SELECT 1
                FROM pos_inventory_".$storeId."
                WHERE product_id = $id";
        $result = $db->query($sql);
        if($db->error){
          $return['status'] = 'err';
          $return['errors'][] = $db->error;
          return $return;
        }
        if($result->num_rows){
          $sql = "UPDATE pos_inventory_".$storeId."
                  SET product_stock = product_stock + $qty
                  WHERE product_id = $id";
        } else {
          if($qty <= 0){
            return $return;
          }
          $sql = "SELECT products_price
                  FROM products
                  WHERE products_id = $id";
          $result = $db->query($sql)->fetch_array(MYSQLI_NUM);
          if($db->error){
            $return['status'] = 'err';
            $return['errors'][] = $db->error;
            return $return;
          }
          $price = number_format($result[0], 2);

          $sql = "INSERT INTO pos_inventory_".$storeId."
                  SET product_id = $id,
                      product_price = $price,
                      product_stock = $qty,
                      last_in_stock = '".date("Y-m-d H:i:s")."'";
          $db->query($sql);
          if($db->error){
            $return['status'] = 'err';
            $return['errors'][] = $db->error;
            return $return;
          }
        }
      }
      $db->query($sql);
      if($db->error){
        $return['status'] = 'err';
        $return['errors'][] = $db->error;
        return $return;
      }

      if($storeId === 1){
        $sql = "SELECT products_quantity
                FROM products
                WHERE products_id = $id";
      } else {
        $sql = "SELECT product_stock
                FROM pos_inventory_".$storeId."
                WHERE product_id = $id";
      }
      $result = $db->query($sql)->fetch_array(MYSQLI_NUM);
      if($db->error){
        $return['status'] = 'err';
        $return['errors'][] = $db->error;
        return $return;
      }

      if($result[0] <= 0){
        if($storeId === 1){
          $sql = "UPDATE products
                  SET products_quantity = 0,
                      products_status = 0
                  WHERE products_id = $id";
        } else {
          $sql = "DELETE FROM pos_inventory_".$storeId."
                  WHERE product_id = $id";
        }
        $db->query($sql);
        if($db->error){
          $return['status'] = 'err';
          $return['errors'][] = $db->error;
          return $return;
        }
      } else {
        if($storeId === 1){
          $sql = "UPDATE products
                  SET products_status = 1
                  WHERE products_id = $id";
          $db->query($sql);
          if($db->error){
            $return['status'] = 'err';
            $return['errors'][] = $db->error;
            return $return;
          }
        }
      }
      return $return;
    }
  }
