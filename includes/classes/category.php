<?php
  class Category {
    function __construct($db){
      $this->db = $db;
    }

    function getAllCategories(){
      $sql = "SELECT categories_id, categories_name
              FROM categories_description
              ORDER BY categories_id ASC";
      $result = $this->db->query($sql);
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $return[] = $row;
      }
      return $return;
    }

    function getCategoryTree($id){
      $sql = "SELECT categories_id, categories_name
              FROM categories_description
              WHERE categories_id = $id
              ORDER BY categories_id ASC";
      $result = $this->db->query($sql);
      $sql2 = "SELECT categories_id
              FROM categories
              WHERE parent_id = ?";
      $stmt = $this->db->prepare($sql2);
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $result = $row;
        $children = array();
        $stmt->bind_param("i", $row['categories_id']);
        $stmt->execute();
        $stmt->bind_result($parent);
        $stmt->store_result();
        while($row2 = $stmt->fetch()){
          $subCat = new Category($this->db);
          $children[] = $subCat->getCategoryTree($parent);
        }
        $result['children'] = $children;
        $return[] = $result;
      }
      return $return;
    }
  }
?>
