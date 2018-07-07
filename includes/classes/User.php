<?php
  class User {
    function __construct($db){
      $this->db = $db;
    }

    function authorize($id, $token){
      $db = $this->db;

      $sql = "SELECT 1
              FROM pos_auth
              WHERE id = ?
              AND token = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("is", $id, $token);
      $stmt->execute();
      $stmt->store_result();
      echo $stmt->num_rows;
      return ($stmt->num_rows) ? true : false;
    }
  }
?>
