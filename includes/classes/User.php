<?php
  class User {
    function _construct($db){
      $this->db = $db;
    }

    function authorize($id, $token){
      $db = $this->db;

      $sql = "SELECT store_id
              FROM pos_auth
              WHERE id = ?
              AND token = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("ss", $id, $token);
      $stmt->execute();
      return ($stmt->num_rows) ? true : false;
    }
  }
?>
