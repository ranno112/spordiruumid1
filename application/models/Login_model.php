<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('email',$email);
    $this->db->where('pw_hash',$password);
    $result = $this->db->get('users',1);
    return $result;
  }
 
	function is_already_register($id)
	{
	 $this->db->where('login_oauth_uid', $id);
	 $query = $this->db->get('users');
	 if($query->num_rows() > 0)
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
	}
 
	function update_user_data($data, $id)
	{
	 $this->db->where('login_oauth_uid', $id);
	 $this->db->update('users', $data);
	}
 
	function insert_user_data($data)
	{
	 $this->db->insert('users', $data);
	}


}
