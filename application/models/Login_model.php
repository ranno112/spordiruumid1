<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('email',$email);
    $this->db->where('pw_hash',$password);
    $result = $this->db->get('users',1);
    return $result;
  }
 
	function insert_user_data($data)
	{
	 $this->db->insert('users', $data);
	}


	// Model for Google OAuth begin
	function is_already_register($id)
	{
	 $this->db->where('email', $id);
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
	// Modal for Google end



	//Model for Facebook begin
	public function checkUser($userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select('login_oauth_uid');
         
            $this->db->where(array('login_oauth_uid'=>$userData['login_oauth_uid']));
            $prevQuery = $this->db->get('users');
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $userData['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update('users', $userData, array('login_oauth_uid' => $prevResult['login_oauth_uid']));
                
                //get user ID
                $userID = $prevResult['login_oauth_uid'];
            }else{
                //insert user data
                $userData['created_at']  = date("Y-m-d H:i:s");
                $userData['updated_at'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert('users', $userData);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID?$userID:FALSE;
    }
	//Model for Facebook end


	function get_user_info($email){
		$this->db->where('email',$email);
		$this->db->join('rooms', 'users.buildingID = rooms.buildingID' , 'left');
		$result = $this->db->get('users',1);
		return $result;
		}

}
