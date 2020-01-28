<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('email',$email);
    $this->db->where('pw_hash',$password);
    $result = $this->db->get('users',1);
    return $result;
  }
 
}