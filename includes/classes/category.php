<?php
  class Category {
    function __construct($db){
      $this->db = $db;
    }

    function getCategoryTree($id){
      $db = $this->db;

      $sql = "SELECT cd.categories_id, cd.categories_name
              FROM categories_description cd
              LEFT JOIN categories c ON cd.categories_id = c.categories_id";
      $sql .= ($id ? " WHERE cd.categories_id = $id" : " WHERE c.parent_id = 0") ;
      $sql .= " ORDER BY cd.categories_id ASC";
      $result = $db->query($sql);
      $sql2 = "SELECT categories_id
              FROM categories
              WHERE parent_id = ?";
      $stmt = $db->prepare($sql2);
      $return = array();
      if($result->num_rows){
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
          $output = array(
            'categories_id' => (int)$row['categories_id'],
            'categories_name' => $row['categories_name']
          );
          $children = array();
          $stmt->bind_param("i", $row['categories_id']);
          $stmt->execute();
          $stmt->bind_result($parent);
          $stmt->store_result();
          while($row2 = $stmt->fetch()){
            $subCat = new Category($this->db);
            $children[] = $subCat->getCategoryTree($parent);
          }
          $output['children'] = $children;
          $return[] = $output;
        }
      }
      return $return;
    }
  }
?>
