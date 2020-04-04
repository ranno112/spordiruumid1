<?php
	class Building_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function get_building($slug = FALSE){
			if($slug === FALSE){
			$this->db->order_by('buildings.id');
			//$this->db->join('rooms', ' buildings.id = rooms.buildingID' , 'left');
			$this->db->join('regions', ' buildings.regionID = regions.regionID' , 'left');
			$query = $this->db->get('buildings');
			return $query->result_array();
			}
			$this->db->join('rooms', ' buildings.id = rooms.buildingID' , 'left');
			$this->db->join('regions', ' buildings.regionID = regions.regionID' , 'left');
			$query = $this->db->get_where('buildings', array('buildings.id' => $slug));
			return $query->result_array();
		
		}


		public function get_rooms(){
			$this->db->order_by('buildingID');
			$query = $this->db->get('rooms');
			return $query->result_array();
		}

		public function get_all_roomsID_from_one_building($buildingID){
			$this->db->select('id');
			$this->db->where('buildingID', $buildingID);
			$query = $this->db->get('rooms');
			return $query->result();
		}


		public function delete_building($id){
			$this->db->where('id', $id);
			$this->db->delete('buildings');
			return true;
		}

		public function check_if_room_has_reservations_only_in_past($id){
			$query1 = $this->db->get_where('bookingTimes', array('roomID' => $id));
			foreach ($query1->result() as $row)
				{
					$lastYear = strtotime("-1 year");
					if (strtotime($row->endTime)>$lastYear ){
						return false;
					}
				}
			return true;
		}

		public function checkIfRoomIsBookable($roomID)
		{
				$this->db->where('rooms.buildingID', $this->session->userdata('building'));
				$this->db->where('rooms.id',$roomID);
				$query = $this->db->get('rooms');
				return $query->result();
		}


		public function delete_room($id){
			$query1 = $this->db->get_where('bookingTimes', array('roomID' => $id));
			foreach ($query1->result() as $row)
				{
					
					$today = strtotime('today UTC');
					if (strtotime($row->endTime)>$today ){
						return false;
						echo $row->endTime;
					}
				
					
				}
		
			
			$this->db->where('id', $id);
			$this->db->delete('rooms');
			return true;
		}


		public function create_category(){
			$data = array(
				'name' => $this->input->post('name'),
				'building_id' => $this->session->buildingdata('building_id')
			);
			return $this->db->insert('categories', $data);
		}



		public function registerBuilding(){
		
			$data = array(
				'name' => $this->input->post('name'),
				'contact_email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'notify_email' => $this->input->post('notifyEmail'),
				'regionID' => $this->input->post('place'),
			//	'price_url' => $this->input->post('price_url'),				
			);
		
			return $this->db->insert('buildings', $data);
		}




	
		public function update_building($data){
			
		
			$this->db->where('id', $this->input->post('id'));

			return $this->db->update('buildings', $data);
		}

		public function update_room($data, $roomID){
			
		
			$this->db->where('id',$roomID);

			return $this->db->update('rooms', $data);
		}



		public function createNewRoom($data){
			
			// Insert room
			return $this->db->insert('rooms', $data);
		
		}



		function getAllRegions()
		{
		  
			$this->db->order_by('regionID');
			$query = $this->db->get('regions');
			return $query->result_array();
		}


	}
