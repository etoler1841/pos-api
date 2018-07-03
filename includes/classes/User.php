<?php
  class User {
    function _construct($db){
      $this->db = $db;
    }

    function authorize($token){
      $db = $this->db;

      $sql = "SELECT store_id
              FROM pos_auth
              WHERE token = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param($token);
      $stmt->execute();
      return ($stmt->num_rows) ? true : false;
    }
  }
?>
