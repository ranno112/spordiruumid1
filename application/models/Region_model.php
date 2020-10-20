<?php
	class Region_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}


		public function get_region($slug ){
			
			$query = $this->db->get_where('regions', array('regions.regionID' => $slug));
			return $query->result_array();
		
		}

		function getAllRegions()
		{
		  
			$this->db->order_by('regionID');
			$query = $this->db->get('regions');
			return $query->result_array();
		}

		public function registerRegion(){
		
			$data = array(
				'regionName' => $this->input->post('region')
			);
		
			return $this->db->insert('regions', $data);
		}

	
		public function update_region($data){
			
		
			$this->db->where('regionID', $this->input->post('regionID'));

			return $this->db->update('regions', $data);
		}

		
		public function delete_region($id){
			$this->db->where('regionID', $id);
			$this->db->delete('regions');
			return true;
		}

		public function check_if_region_has_buildings($id){
			$this->db->where('regionID', $id);
			$query = $this->db->get('buildings');
			return $query->num_rows();
		}

		function getUnapprovedBookings($buildingID )
		{
			$this->db->select("roomID, approved, startTime, id, buildingID");
			$this->db->where('DATE(startTime) >=', date('Y-m-d'));
			$this->db->join('rooms', 'bookingTimes.roomID = rooms.id' , 'left');
			$this->db->where('rooms.buildingID', $buildingID);
			$this->db->where('approved !=', 1);
			$query = $this->db->count_all_results('bookingTimes');
	
			return $query;
		}

	

	}
