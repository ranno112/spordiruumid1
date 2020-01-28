<?php
	class Profile_model extends CI_Model{

		public function __construct(){
			$this->load->database();
        }

		public function get_profile($slug = FALSE){
			if($slug === FALSE){
				echo "pole SLUGI";
			//$this->db->order_by('buildings.id');
			//$this->db->join('rooms', ' buildings.id = rooms.buildingID' , 'left');
			
			$query = $this->db->get('users');
			return $query->result_array();
			} else {
			
			$this->db->join('buildings', ' buildings.id = users.buildingID' , 'left');
			$query = $this->db->get_where('users', array('userID' => $slug));
			return $query->result_array();
		
		}}


		public function update_profile(){
		
			$data = array(
				'userName' => $this->input->post('name'),
				'userPhone' => $this->input->post('phone'),
				
			);
			$this->db->where('userID', $this->session->userdata['userID']);

			//siia tuleb parooliga seonduv

			//kõige pealt peab tegema validation, kas password==password2

			$data2 = array(
				//'pw_hash' => $this->input->post('password'),
				
			);

			return $this->db->update('users', $data);
		}


    
    }