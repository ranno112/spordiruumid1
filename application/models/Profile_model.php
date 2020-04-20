<?php
	class Profile_model extends CI_Model{

		public function __construct(){
			$this->load->database();
        }

		public function get_profile($slug = FALSE){
			
			$this->db->join('buildings', ' buildings.id = users.buildingID' , 'left');
			$query = $this->db->get_where('users', array('userID' => $slug));
			return $query->result_array();
		
		}


		public function update_profile($data){
		
			
			$this->db->where('userID', $this->session->userdata['userID']);

			//siia tuleb parooliga seonduv

			//kõige pealt peab tegema validation, kas password==password2

			$data2 = array(
				//'pw_hash' => $this->input->post('password'),
				
			);

			return $this->db->update('users', $data);
		}


		public function get_my_buildingID(){

			$this->db->select('buildingID');  
			$this->db->where('userID',$this->session->userdata['userID']);
			$query = $this->db->get('users');
			return $query->row_array();
		}

	
		function get_hash($email){
			$this->db->select('pw_hash');  
			$this->db->where('email',$email);
			$result = $this->db->get('users');
			return $result->row_array();

		  }

    }
