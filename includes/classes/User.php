<?php
  class User {function __construct($db){
      $this->db = $db;
    }

    function authorize(){
      $db = $this->db;

      $headers = $_SERVER;
      if(!isset($headers['HTTP_AUTHORIZATION'])){
        $return['status'] = 'err';
        $return['errors'][] = 'Authorization missing';
        return $return;
      }
      $auth = $headers['HTTP_AUTHORIZATION'];
      if(!preg_match('/bearer .+/i', $auth)){
        $return['status'] = 'err';
        $return['errors'][] = 'Bearer token missing';
        return $return;
      }
      $token = preg_replace('/bearer /i', '', $auth);

      $sql = "SELECT id
              FROM pos_auth
              WHERE token = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("s", $token);
      $stmt->execute();
      $stmt->bind_result($id);
      $stmt->store_result();
      if(!$stmt->num_rows){
        $return['status'] = 'err';
        $return['errors'][] = 'Authorization rejected';
        return $return;
      } else {
        $return['status'] = 'ok';
        $return['errors'] = array();

        $stmt->fetch();
        $this->storeId = $id;

        return $return;
      }
    }
  }
?>
